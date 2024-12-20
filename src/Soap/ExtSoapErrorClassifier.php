<?php

declare(strict_types=1);

namespace Twint\Sdk\Soap;

use Override;
use Phpro\SoapClient\Exception\SoapException;
use SoapFault;
use stdClass;
use Throwable;

final class ExtSoapErrorClassifier implements ErrorClassifier
{
    private const KNOWN_ERRORS = [
        self::STATUS_TRANSITION_ERROR => '1200',
    ];

    #[Override]
    public function isOfType(Throwable $t, string $type): bool
    {
        if (!$t instanceof SoapException) {
            return false;
        }

        $prev = $t->getPrevious();
        if (!$prev instanceof SoapFault) {
            return false;
        }

        $detail = $prev->detail;
        return $detail instanceof stdClass
            && ($detail->{$type} ?? null) instanceof stdClass
            && ($detail->{$type}->ErrorCode ?? null) instanceof stdClass
            && ($detail->{$type}->ErrorCode->Status ?? null) === $type
            && ($detail->{$type}->ErrorCode->Code ?? null) === self::KNOWN_ERRORS[$type];
    }
}
