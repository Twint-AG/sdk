<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools;

use ReflectionClass;
use ReflectionException;
use Twint\Sdk\Client;

final class ClientResetter
{
    /**
     * @throws ReflectionException
     */
    public static function reset(Client $client): void
    {
        (new ReflectionClass(Client::class))
            ->getProperty('enrolledCashRegisters')
            ->setValue($client, []);
    }
}
