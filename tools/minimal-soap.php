<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

use Exception;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflector\DefaultReflector;
use Roave\BetterReflection\Reflector\Reflector;
use Roave\BetterReflection\SourceLocator\Type\AggregateSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\AutoloadSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\FileIteratorSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\MemoizingSourceLocator;
use Roave\BetterReflection\SourceLocator\Type\PhpInternalSourceLocator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Twint\Sdk\Tools\Parser\SymbolCollectingVisitor;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\vec;

require __DIR__ . '/../vendor/autoload.php';

/**
 * @throws Exception
 */
function createReflector(): Reflector
{
    $betterReflection = new BetterReflection();

    return new DefaultReflector(
        new MemoizingSourceLocator(
            new AggregateSourceLocator([
                new FileIteratorSourceLocator(
                    Finder::create()
                        ->name('*.php')
                        ->in(__DIR__ . '/../src')
                        ->getIterator(),
                    $betterReflection->astLocator()
                ),
                new PhpInternalSourceLocator($betterReflection->astLocator(), $betterReflection->sourceStubber()),
                new AutoloadSourceLocator($betterReflection->astLocator(), $betterReflection->phpParser()),
            ])
        )
    );
}

function createParser(): Parser
{
    return (new ParserFactory())->createForNewestSupportedVersion();
}

function createTraverser(): NodeTraverser
{
    $traverser = new NodeTraverser();
    $traverser->addVisitor(new NameResolver());

    return $traverser;
}

$parser = createParser();

const NAMESPACE_ = 'Phpro\\SoapClient\\';
const SOURCE_DIRECTORY = __DIR__ . '/../vendor/phpro/soap-client/src/';
const TARGET_DIRECTORY = __DIR__ . '/../vendor-bundled/phpro/soap-client-minimal/src/';

$traverser = createTraverser();
$symbolCollector = new SymbolCollectingVisitor(NAMESPACE_);
$traverser->addVisitor($symbolCollector);

$reflector = createReflector();

$fs = new Filesystem();
$fs->remove(TARGET_DIRECTORY);

$visited = [];
$classes = $reflector->reflectAllClasses();

while ($classes) {
    $class = array_shift($classes);

    if (in_array($class->getName(), $visited, true)) {
        continue;
    }

    $visited[] = $class->getName();

    $ast = $parser->parse($class->getLocatedSource()->getSource());

    $traverser->traverse(vec(instance_of(Node::class))->assert($ast));

    foreach ($symbolCollector->getSymbols() as $symbol) {
        if (in_array($symbol, $visited, true)) {
            continue;
        }

        $classes[] = $reflector->reflectClass($symbol);
    }
}

foreach ($symbolCollector->getSymbols() as $symbol) {
    $class = $reflector->reflectClass($symbol);

    $sourceFileName = non_empty_string()
        ->assert($class->getLocatedSource()->getFileName());

    $directory = $fs->makePathRelative(dirname($sourceFileName), SOURCE_DIRECTORY);

    $targetFileName = TARGET_DIRECTORY . $directory . '/' . $class->getShortName() . '.php';

    $fs->mkdir(dirname($targetFileName));
    $fs->copy($sourceFileName, $targetFileName, true);
}
