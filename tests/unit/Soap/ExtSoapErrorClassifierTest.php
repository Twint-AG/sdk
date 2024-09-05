<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Soap;

use Error;
use Exception;
use Phpro\SoapClient\Exception\SoapException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use SoapFault;
use Throwable;
use Twint\Sdk\Soap\ErrorClassifier;
use Twint\Sdk\Soap\ExtSoapErrorClassifier;

/**
 * @internal
 */
#[CoversClass(ExtSoapErrorClassifier::class)]
final class ExtSoapErrorClassifierTest extends TestCase
{
    /**
     * @return iterable<array{bool, string, Throwable}>
     */
    public static function getExamplesOfThrowables(): iterable
    {
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, new Exception()];
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, new SoapException()];
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, new Error()];
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, SoapException::fromThrowable(new Exception())];
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, SoapException::fromThrowable(new SoapException())];
        yield [false, ErrorClassifier::STATUS_TRANSITION_ERROR, SoapException::fromThrowable(new Error())];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(self::createSoapFault(null)),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(self::createSoapFault('')),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(self::createSoapFault((object) [])),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(self::createSoapFault((object) [
                'foo' => 'bar',
            ])),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    'SomeOtherError' => [
                        'ErrorCode' => (object) [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    'SomeOtherError' => (object) [
                        'ErrorCode' => [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
        yield [
            false,
            'SomeOtherError',
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    'SomeOtherError' => (object) [
                        'ErrorCode' => [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
        yield [
            false,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    'SomeOtherError' => (object) [
                        'ErrorCode' => (object) [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
        yield [
            true,
            ErrorClassifier::STATUS_TRANSITION_ERROR,
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    ErrorClassifier::STATUS_TRANSITION_ERROR => (object) [
                        'ErrorCode' => (object) [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
        yield [
            false,
            'SOME_OTHER_ERROR',
            SoapException::fromThrowable(
                self::createSoapFault((object) [
                    ErrorClassifier::STATUS_TRANSITION_ERROR => (object) [
                        'ErrorCode' => (object) [
                            'Code' => '1200',
                            'Status' => ErrorClassifier::STATUS_TRANSITION_ERROR,
                        ],
                    ],
                ])
            ),
        ];
    }

    #[DataProvider('getExamplesOfThrowables')]
    public function testErrorClassificationForExtSoapFaults(bool $expected, string $type, Throwable $throwable): void
    {
        /** @phpstan-ignore-next-line argument.type */
        self::assertSame($expected, (new ExtSoapErrorClassifier())->isOfType($throwable, $type));
    }

    private static function createSoapFault(mixed $detail): SoapFault
    {
        $fault = new SoapFault('code', 'message');
        $fault->detail = $detail;

        return $fault;
    }
}
