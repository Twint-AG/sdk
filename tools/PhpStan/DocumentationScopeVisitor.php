<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PhpStan;

use Override;
use PhpParser\Node;
use PhpParser\NodeFinder;
use PhpParser\NodeVisitor;
use PhpParser\NodeVisitorAbstract;
use PHPStan\Parser\Parser;
use PHPStan\Parser\ParserErrorsException;

final class DocumentationScopeVisitor extends NodeVisitorAbstract
{
    /**
     * @var array<string, array<Node>>
     */
    private static array $prependNodes = [];

    private readonly NodeVisitor $delegate;

    /**
     * @throws ParserErrorsException
     */
    public function __construct(
        string $prependFilePath,
        private readonly Parser $parser,
        NodeFinder $nodeFinder
    ) {
        self::$prependNodes[$prependFilePath] ??= $this->parser->parseFile($prependFilePath);
        $this->delegate = new DocumentationScopePrepender(self::$prependNodes[$prependFilePath], $nodeFinder);
    }

    /**
     * @return array<Node>
     */
    #[Override]
    public function leaveNode(Node $node): Node|int|array|null
    {
        return $this->delegate->leaveNode($node);
    }

    /**
     * @param array<Node> $nodes
     * @return array<Node>
     */
    #[Override]
    public function afterTraverse(array $nodes): array
    {
        return $this->delegate->afterTraverse($nodes) ?? $nodes;
    }
}
