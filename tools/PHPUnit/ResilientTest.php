<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit;

use Override;
use PHPUnit\Framework\IncompleteTest;
use PHPUnit\Framework\SkippedTest;
use PHPUnit\Framework\TestCase;
use ReflectionObject;
use Throwable;

/**
 * @phpstan-require-extends TestCase
 * @mixin TestCase
 */
trait ResilientTest
{
    #[Override]
    final protected function runTest(): mixed
    {
        if (!self::shouldRetryTest($this)) {
            return parent::runTest();
        }

        $maxRetries = self::retryTimes($this);
        for ($retry = 0; $retry < $maxRetries; ++$retry) {
            try {
                return parent::runTest();
            } catch (SkippedTest|IncompleteTest $e) {
                throw $e;
            } catch (Throwable $e) {
                if ($retry === $maxRetries - 1) {
                    throw $e;
                }
                error_log(sprintf('Retrying %s (%d of %d)', $this->name(), $retry + 1, $maxRetries));
            }
        }

        return parent::runTest();
    }

    private static function shouldRetryTest(TestCase $testCase): bool
    {
        return self::retryTimes($testCase) > 1;
    }

    private static function retryTimes(TestCase $testCase): int
    {
        $class = new ReflectionObject($testCase);

        $currentClass = $class;
        do {
            $classAttributes = $currentClass->getAttributes(Retry::class);
            if (count($classAttributes) > 0) {
                return $classAttributes[0]->newInstance()->times ?? 1;
            }

            $methodAttributes = $currentClass->getMethod($testCase->name())
                ->getAttributes(Retry::class);
            if (count($methodAttributes) > 0) {
                return $methodAttributes[0]->newInstance()->times ?? 1;
            }
        } while ($currentClass = $currentClass->getParentClass());

        return 1;
    }
}
