<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use PHPUnit\Runner\Extension\Extension;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use Twint\Sdk\Checks\PHPUnit\Subscriber\ConfigureVcr;
use Twint\Sdk\Checks\PHPUnit\Subscriber\PrepareVcr;
use Twint\Sdk\Checks\PHPUnit\Subscriber\TurnOffVcr;

final class VcrExtension implements Extension
{
    public function bootstrap(Configuration $configuration, Facade $facade, ParameterCollection $parameters): void
    {
        $fixtureVersionHeader = 'Twint-SDK-Fixture-Version';
        $fixtureVersionMatcher = 'fixture_version';

        $facade->registerSubscribers(
            new ConfigureVcr($fixtureVersionMatcher, $fixtureVersionHeader),
            new PrepareVcr($fixtureVersionMatcher),
            new TurnOffVcr()
        );
    }
}
