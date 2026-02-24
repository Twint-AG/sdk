<?php

declare(strict_types=1);

namespace Twint\Sdk\Value;

/**
 * @template-covariant T of scalar
 */
interface PairingToken
{
    /**
     * @return T
     */
    public function token();
}
