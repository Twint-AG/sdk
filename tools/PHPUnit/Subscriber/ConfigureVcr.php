<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\PHPUnit\Subscriber;

use PHPUnit\Event\Code\TestMethodBuilder;
use PHPUnit\Event\TestRunner\BootstrapFinished;
use PHPUnit\Event\TestRunner\BootstrapFinishedSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Twint\Sdk\Tools\PHPUnit\MutableResponse;
use Twint\Sdk\Tools\PHPUnit\VcrUtil;
use VCR\Event\BeforePlaybackEvent;
use VCR\Event\BeforeRecordEvent;
use VCR\Request;
use VCR\VCR;
use VCR\VCREvents;

final class ConfigureVcr implements BootstrapFinishedSubscriber
{
    public function __construct(
        private readonly string $fixtureVersionMatcher,
        private readonly string $fixtureVersionHeader
    ) {
    }

    public function notify(BootstrapFinished $event): void
    {
        $configuration = VCR::configure();
        $configuration->addRequestMatcher(
            $this->fixtureVersionMatcher,
            function (Request $stored, Request $incoming) {
                return $stored->getHeader($this->fixtureVersionHeader) === (string) VcrUtil::getFixtureRevision(
                    TestMethodBuilder::fromCallStack()
                );
            }
        );

        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(
            VCREvents::VCR_BEFORE_RECORD,
            function (BeforeRecordEvent $event) {
                $event->getRequest()
                    ->setHeader(
                        $this->fixtureVersionHeader,
                        (string) VcrUtil::getFixtureRevision(TestMethodBuilder::fromCallStack())
                    );
            }
        );
        $dispatcher->addListener(VCREvents::VCR_BEFORE_PLAYBACK, [self::class, 'censorRequest'](...));
        $dispatcher->addListener(VCREvents::VCR_BEFORE_RECORD, [self::class, 'censorRequest'](...));
        $dispatcher->addListener(VCREvents::VCR_BEFORE_RECORD, [self::class, 'censorResponse'](...));
        VCR::setEventDispatcher($dispatcher);

        VCR::turnOn();
    }

    private static function censorRequest(BeforeRecordEvent|BeforePlaybackEvent $event): void
    {
        $attribute = VcrUtil::tryGetAttribute(TestMethodBuilder::fromCallStack());
        $attribute?->censorRequest?->__invoke($event->getRequest());
    }

    private static function censorResponse(BeforeRecordEvent $event): void
    {
        $attribute = VcrUtil::tryGetAttribute(TestMethodBuilder::fromCallStack());
        $attribute?->censorResponse?->__invoke(new MutableResponse($event->getResponse()));
    }
}
