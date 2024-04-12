<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit\Subscriber;

use PHPUnit\Event\Test\Prepared;
use PHPUnit\Event\Test\PreparedSubscriber;
use Twint\Sdk\Tools\PHPUnit\VcrUtil;
use VCR\VCR;

final class PrepareVcr implements PreparedSubscriber
{
    public function __construct(
        private readonly string $fixtureVersionMatcher
    ) {
    }

    public function notify(Prepared $event): void
    {
        $attribute = VcrUtil::tryGetAttribute($event->test());

        if ($attribute === null) {
            VcrUtil::turnOff();
            return;
        }

        $configuration = VCR::configure();
        $configuration->setStorage('yaml');

        $configuration->enableRequestMatchers([$this->fixtureVersionMatcher, ...$attribute->requestMatchers]);

        VcrUtil::turnOn();
        VCR::insertCassette(VcrUtil::getCassetteName($event->test()) . '.yaml');
    }
}
