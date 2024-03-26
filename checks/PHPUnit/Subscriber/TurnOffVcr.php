<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit\Subscriber;

use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;
use VCR\VCR;

final class TurnOffVcr implements FinishedSubscriber
{
    public function notify(Finished $event): void
    {
        VCR::turnOff();
    }
}
