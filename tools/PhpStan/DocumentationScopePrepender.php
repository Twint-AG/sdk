<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PhpStan;

use Override;
use PhpParser\Node;
use PhpParser\Node\Stmt\Namespace_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use function Psl\invariant;
use function Psl\Type\instance_of;
use function Psl\Type\vec;

final class DocumentationScopePrepender extends NodeVisitorAbstract
{
    /**
     * @param array<Node> $prependNodes
     */
    public function __construct(
        private readonly array $prependNodes,
        private readonly NodeFinder $nodeFinder
    ) {
    }

    /**
     * @return array<Node>|int|null
     */
    #[Override]
    public function leaveNode(Node $node): int|array|null
    {
        return match (true) {
            $node instanceof Namespace_ => $this->handleNamespace($node),
            $node instanceof Use_ => $this->handleUse($node),
            default => null,
        };
    }

    private function handleUse(Use_ $use): int|null
    {
        $duplicateUse = $this->nodeFinder->findFirst(
            $this->prependNodes,
            static fn (Node $maybeUse) =>
                $maybeUse instanceof Use_
                && $maybeUse->uses[0]->name->toString() === $use->uses[0]->name->toString()
                && $maybeUse->type === $use->type
        );

        return $duplicateUse !== null ? NodeTraverser::REMOVE_NODE : null;
    }

    /**
     * @return array<Node>
     */
    private function handleNamespace(Namespace_ $namespace): array
    {
        $prependFileNamespaces = $this->nodeFinder->findInstanceOf($this->prependNodes, Namespace_::class);

        invariant(count($prependFileNamespaces) === 1, 'Prepend file must have exactly one namespace declaration');
        vec(instance_of(Namespace_::class))->assert($prependFileNamespaces);
        invariant(
            $prependFileNamespaces[0]->name?->toString() === $namespace->name?->toString(),
            'Prepend file must have the same namespace as the file being traversed. Prepend file namespace is "%s", documentation namespace is "%s"',
            $prependFileNamespaces[0]->name?->toString() ?? '\\',
            $namespace->name?->toString() ?? '\\'
        );

        return $namespace->stmts;
    }

    /**
     * @param array<Node> $nodes
     * @return array<Node>
     */
    #[Override]
    public function afterTraverse(array $nodes): array
    {
        $combined = $this->prependNodes;

        vec(instance_of(Node\Stmt::class))->assert($combined);
        instance_of(Namespace_::class)->assert($combined[0]);
        vec(instance_of(Node\Stmt::class))->assert($nodes);

        $combined[0]->stmts = array_merge($combined[0]->stmts, $nodes);

        return $combined;
    }
}
