<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

use Override;
use Twint\Sdk\Util\Type;
use function Psl\Type\instance_of;

/**
 * @template-implements Enum<self::*>
 * @template-implements Value<self>
 */
final class Environment implements Value, Enum
{
    /** @use ComparableToEquality<self> */
    use ComparableToEquality;

    public const TESTING = 'TESTING';

    public const PRODUCTION = 'PRODUCTION';

    /**
     * @param self::* $value
     */
    public function __construct(
        private readonly string $value
    ) {
        Type::maybeUnionOfLiterals(...self::all())->assert($value);
    }

    #[Override]
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

    #[Override]
    public function __toString(): string
    {
        return $this->value;
    }

    #[Override]
    public function compare($other): int
    {
        instance_of(self::class)->assert($other);

        return $this->value <=> $other->value;
    }

    public function appSchemeUrl(): Url
    {
        return new Url('https://' . $this->appSchemeHost() . '/appSwitch/v1/configs');
    }

    public function soapWsdlPath(Version $version): ExistingPath
    {
        return new ExistingPath(
            __DIR__ . '/../../resources/wsdl/v' . $version->dotVersion() . '/TWINTMerchantService_v' . $version->dotVersion() . '.wsdl'
        );
    }

    public function soapEndpoint(Version $version): Url
    {
        return new Url(
            'https://' . $this->getServiceHost() . '/merchant/service/TWINTMerchantServiceV' . $version->underscoreVersion()
        );
    }

    public function soapTargetNamespace(Version $version): Url
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

    #[Override]
    public function jsonSerialize(): string
    {
        return $this->value;
    }
}
