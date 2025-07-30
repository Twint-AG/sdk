<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

use Composer\InstalledVersions;
use Composer\Semver\Constraint\ConstraintInterface;
use Composer\Semver\VersionParser;
use Exception;
use JsonException;
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
use Symfony\Component\Filesystem\Path;
use Symfony\Component\Finder\Finder;
use Twint\Sdk\Tools\Parser\SymbolCollectingVisitor;
use function Psl\File\read;
use function Psl\Type\dict;
use function Psl\Type\instance_of;
use function Psl\Type\non_empty_string;
use function Psl\Type\optional;
use function Psl\Type\shape;
use function Psl\Type\vec;

require __DIR__ . '/../vendor/autoload.php';

const PROJECT_ROOT = __DIR__ . '/..';


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
                        ->in(Path::join(PROJECT_ROOT, '/src'))
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

/**
 * @param non-empty-string $path
 * @throws Exception
 * @return array{
 *     "autoload"?: array{
 *          "psr-0"?: array<non-empty-string, non-empty-string>,
 *          "psr-4"?: array<non-empty-string, non-empty-string>,
 *     },
 *     "require"?: array<non-empty-string, non-empty-string>,
 * }
 */
function readComposerJson(string $path): array
{
    try {
        // @phpstan-ignore-next-line return.type See https://github.com/php-standard-library/phpstan-extension/issues/16
        return shape(
            [
                'autoload' => optional(
                    shape(
                        [
                            'psr-0' => optional(dict(non_empty_string(), non_empty_string())),
                            'psr-4' => optional(dict(non_empty_string(), non_empty_string())),
                        ],
                        true
                    )
                ),
                'require' => optional(dict(non_empty_string(), non_empty_string())),
            ],
            true
        )->assert(json_decode(read($path), true, 512, JSON_THROW_ON_ERROR));
    } catch (JsonException $e) {
        throw new Exception(sprintf('Failed to read composer.json from %s: %s', $path, $e->getMessage()), 0, $e);
    }
}

/**
 * @param non-empty-string $packageName
 * @param non-empty-string $target
 * @throws Exception
 * @return array{array<non-empty-string, non-empty-string>, array<non-empty-string, ConstraintInterface>}
 */
function copyPackage(
    Filesystem $fs,
    Parser $parser,
    VersionParser $versionParser,
    string $packageName,
    string $target
): array {
    $installPath = non_empty_string()
        ->assert(InstalledVersions::getInstallPath($packageName));

    $composerJson = readComposerJson(Path::join($installPath, 'composer.json'));

    $psr4 = [];

    foreach ($composerJson['autoload']['psr-0'] ?? [] as $namespace => $sourceFolder) {
        $sourceDirectory = Path::join($installPath, $sourceFolder);
        $targetDirectory = Path::join($target, $packageName . '-minimal', $sourceFolder);
        printf(
            "Finding referenced symbols in package \"%s\" from PSR-0 namespace \"%s\" in \"%s\"\n",
            $packageName,
            $namespace,
            Path::makeRelative($sourceDirectory, PROJECT_ROOT)
        );
        copySymbols($fs, $parser, $namespace, $targetDirectory, $sourceDirectory);
        $psr4[$namespace] = Path::join($targetDirectory, str_replace('\\', '/', $namespace));
    }

    foreach ($composerJson['autoload']['psr-4'] ?? [] as $namespace => $sourceFolder) {
        $sourceDirectory = Path::join($installPath, $sourceFolder);
        $targetDirectory = Path::join($target, $packageName . '-minimal', $sourceFolder);
        printf(
            "Finding referenced symbols in package \"%s\" from PSR-4 namespace \"%s\" in \"%s\"\n",
            $packageName,
            $namespace,
            Path::makeRelative($sourceDirectory, PROJECT_ROOT)
        );
        copySymbols($fs, $parser, $namespace, $targetDirectory, $sourceDirectory);
        $psr4[$namespace] = $targetDirectory;
    }

    foreach ($psr4 as $namespace => $sourceDirectory) {
        $psr4[$namespace] = non_empty_string()
            ->assert(Path::makeRelative($sourceDirectory, PROJECT_ROOT));
    }

    $constraints = [];
    foreach ($composerJson['require'] ?? [] as $package => $constraint) {
        $constraints[$package] = $versionParser->parseConstraints($constraint);
    }

    return [$psr4, $constraints];
}


/**
 * @param non-empty-string $namespace
 * @param non-empty-string $targetDirectory
 * @param non-empty-string $sourceDirectory
 * @throws Exception
 */
function copySymbols(
    Filesystem $fs,
    Parser $parser,
    string $namespace,
    string $targetDirectory,
    string $sourceDirectory
): void {
    $traverser = createTraverser();
    $symbolCollector = new SymbolCollectingVisitor($namespace);
    $traverser->addVisitor($symbolCollector);

    $reflector = createReflector();

    $fs->remove($targetDirectory);

    $visited = [];
    $classes = $reflector->reflectAllClasses();

    while ($classes !== []) {
        $class = array_shift($classes);

        if (in_array($class->getName(), $visited, true)) {
            continue;
        }

        $visited[] = $class->getName();

        $ast = $parser->parse(read(non_empty_string()->assert($class->getFileName())));

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
            ->assert($class->getFileName());

        $directory = Path::makeRelative(Path::getDirectory($sourceFileName), $sourceDirectory);
        $targetFileName = Path::join($targetDirectory, $directory, $class->getShortName() . '.php');

        $fs->mkdir(dirname($targetFileName));
        printf(
            "Copying symbol \"%s\" from \"%s\" to \"%s\"\n",
            $symbol,
            Path::makeRelative($sourceFileName, PROJECT_ROOT),
            Path::makeRelative($targetFileName, PROJECT_ROOT)
        );
        $fs->copy($sourceFileName, $targetFileName, true);
    }
}

$versionParser = new VersionParser();


function normalizePath(string $path): string
{
    return rtrim($path, DIRECTORY_SEPARATOR);
}

const PACKAGES_TO_BUNDLE = ['phpro/soap-client', 'php-soap/psr18-transport'];

const PACKAGES_TO_IGNORE = [
    'symfony/validator',
    'symfony/filesystem',
    'symfony/console',
    'symfony/event-dispatcher',
    'laminas/laminas-code',
    'php-soap/wsdl-reader',
    'php-soap/wsdl',
];

$rootComposerJson = readComposerJson(Path::join(PROJECT_ROOT, 'composer.json'));
$rootDependencies = [];
$transientDependencies = [];
$psr4Autoloads = [];

foreach ($rootComposerJson['require'] ?? [] as $requireRootPackage => $packageDependencyConstraint) {
    if (in_array($requireRootPackage, PACKAGES_TO_BUNDLE, true)) {
        continue;
    }
    $rootDependencies[$requireRootPackage] = $versionParser->parseConstraints($packageDependencyConstraint);
}

$fs = new Filesystem();

foreach (PACKAGES_TO_BUNDLE as $packageToBundle) {
    [$psr4Autoload, $packageDependencies] = copyPackage(
        $fs,
        $parser,
        $versionParser,
        $packageToBundle,
        Path::join(PROJECT_ROOT, 'vendor-bundled')
    );
    foreach ($packageDependencies as $packageDependency => $packageDependencyConstraint) {
        if (in_array($packageDependency, PACKAGES_TO_BUNDLE, true)) {
            continue;
        }

        if (in_array($packageDependency, PACKAGES_TO_IGNORE, true)) {
            continue;
        }

        if (!isset($transientDependencies[$packageDependency])) {
            $transientDependencies[$packageDependency] = $packageDependencyConstraint;
        }

        if ($transientDependencies[$packageDependency]->matches($packageDependencyConstraint)) {
            continue;
        }

        if ($packageDependencyConstraint->matches($packageDependencyConstraint)) {
            $transientDependencies[$packageDependency] = $packageDependencyConstraint;
            continue;
        }

        throw new Exception(
            sprintf(
                'Incompatible version constraint for package %s: %s vs %s',
                $packageDependency,
                $transientDependencies[$packageDependency]->getPrettyString(),
                $packageDependencyConstraint->getPrettyString()
            )
        );
    }

    $psr4Autoloads = array_merge($psr4Autoloads, $psr4Autoload);
}

$exitCode = 0;

foreach ($transientDependencies as $expectedRequire => $packageDependencyConstraint) {
    if (!isset($rootDependencies[$expectedRequire])) {
        printf(
            "Missing require in root composer.json: \"%s\": \"%s\"\n",
            $expectedRequire,
            $packageDependencyConstraint->getPrettyString()
        );
        $exitCode = 1;
        continue;
    }

    if (!$rootDependencies[$expectedRequire]->matches($packageDependencyConstraint)) {
        printf(
            "Incompatible version constraint for package %s in root composer.json: %s vs %s\n",
            $expectedRequire,
            $rootDependencies[$expectedRequire]->getPrettyString(),
            $packageDependencyConstraint->getPrettyString()
        );
        $exitCode = 1;
    }
}

foreach ($psr4Autoloads as $namespace => $sourceDirectory) {
    if (!isset($rootComposerJson['autoload']['psr-4'][$namespace])) {
        printf("Missing PSR-4 autoload in root composer.json: \"%s\": \"%s\"\n", $namespace, $sourceDirectory);
        $exitCode = 1;
        continue;
    }

    if (normalizePath($rootComposerJson['autoload']['psr-4'][$namespace]) !== normalizePath($sourceDirectory)) {
        printf(
            "Incompatible PSR-4 autoload for namespace %s in root composer.json: %s vs %s\n",
            $namespace,
            $rootComposerJson['autoload']['psr-4'][$namespace],
            $sourceDirectory
        );
        $exitCode = 1;
    }
}

exit($exitCode);
