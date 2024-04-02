<?php

declare(strict_types=1);

namespace Twint\Sdk;

use Twint\Sdk\Value\Comparable;
use Twint\Sdk\Value\ComparableToEquality;
use Twint\Sdk\Value\Enum;
use Twint\Sdk\Value\Equality;
use Twint\Sdk\Value\File;
use Twint\Sdk\Value\Url;
use function Psl\Type\instance_of;
use function Psl\Type\union;

/**
 * @template-implements Enum<self::*>
 * @template-implements Comparable<self>
 * @template-implements Equality<self>
 */
final class TwintEnvironment implements Enum, Comparable, Equality
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const TESTING = 'TESTING';

    public const PRODUCTION = 'PRODUCTION';

    /**
     * @param self::* $value
     */
    public function __construct(
        private string $value
    ) {
        union(...array_map('Psl\Type\literal_scalar', self::all()))->assert($value);
    }

    public static function all(): array
    {
        return [self::TESTING, self::PRODUCTION];
    }

    public static function PRODUCTION(): self
    {
        return new self(self::PRODUCTION);
    }

    public static function TESTING(): self
    {
        return new self(self::TESTING);
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->value <=> $other->value;
    }

    public function appSchemeUrl(): Url
    {
        return new Url('https://' . $this->appSchemeHost() . '/appSwitch/v1/configs');
    }

    public function soapWsdlPath(TwintVersion $version): File
    {
        return new File(
            __DIR__ . '/../resources/wsdl/v' . $version->dotVersion() . '/TWINTMerchantService_v' . $version->dotVersion() . '.wsdl'
        );
    }

    public function soapEndpoint(TwintVersion $version): Url
    {
        return new Url(
            'https://' . $this->getServiceHost() . '/merchant/service/TWINTMerchantServiceV' . $version->underscoreVersion()
        );
    }

    public function soapTargetNamespace(TwintVersion $version): Url
    {
        return new Url('http://service.twint.ch/header/types/v' . $version->underscoreVersion());
    }

    private function getServiceHost(): string
    {
        return match ($this->value) {
            self::TESTING => 'service-pat.twint.ch',
            self::PRODUCTION => 'service.twint.ch',
        };
    }

    private function appSchemeHost(): string
    {
        return match ($this->value) {
            self::TESTING => 'app.scheme-pat.twint.ch',
            self::PRODUCTION => 'app.scheme.twint.ch',
        };
    }
}
