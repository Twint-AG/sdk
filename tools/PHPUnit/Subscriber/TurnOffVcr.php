<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit\Subscriber;

use Override;
use PHPUnit\Event\Test\Finished;
use PHPUnit\Event\Test\FinishedSubscriber;
use Twint\Sdk\Tools\PHPUnit\VcrUtil;

final class TurnOffVcr implements FinishedSubscriber
{
    #[Override]
    public function notify(Finished $event): void
    {
        VcrUtil::turnOff();
    }
}
