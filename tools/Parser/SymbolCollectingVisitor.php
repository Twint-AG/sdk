<?php


declare(strict_types=1);

namespace Twint\Sdk\Tools\Parser;

use Override;
use PhpParser\Node;
use PhpParser\Node\Name\FullyQualified;
use PhpParser\NodeVisitorAbstract;

final class SymbolCollectingVisitor extends NodeVisitorAbstract
{
    /**
     * @var list<string>
     */
    private array $symbols = [];

    /**
     * @param non-empty-string $namespace
     */
    public function __construct(
        private readonly string $namespace
    ) {
    }

    #[Override]
    public function enterNode(Node $node): Node
    {
        if (!$node instanceof FullyQualified) {
            return $node;
        }

        $symbolName = $node->toString();

        if (in_array($symbolName, $this->symbols, true)) {
            return $node;
        }

        if (!str_starts_with($symbolName, $this->namespace)) {
            return $node;
        }

        $this->symbols[] = $symbolName;

        return $node;
    }

    /**
     * @return list<string>
     */
    public function getSymbols(): array
    {
        return $this->symbols;
    }
}
