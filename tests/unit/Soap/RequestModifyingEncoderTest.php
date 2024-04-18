<?php

declare(strict_types=1);

namespace Twint\Sdk\Tests\Unit\Soap;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Soap\Engine\Encoder;
use Soap\Engine\HttpBinding\SoapRequest;
use Twint\Sdk\Soap\RequestModifyingEncoder;

/**
 * @internal
 */
#[CoversClass(RequestModifyingEncoder::class)]
final class RequestModifyingEncoderTest extends TestCase
{
    public function testInvokesModifierOnRequest(): void
    {
        $invoked = false;
        $wrapped = $this->createMock(Encoder::class);
        $wrapped
            ->expects(self::once())
            ->method('encode')
            ->with('method', ['arg'])
            ->willReturn(new SoapRequest('<original/>', 'http://localhost', 'method', SoapRequest::SOAP_1_1, false));

        $encoder = new RequestModifyingEncoder($wrapped, static function (SoapRequest $request) use (&$invoked) {
            $invoked = true;
            return new SoapRequest(
                '<modified/>',
                $request->getLocation(),
                $request->getAction(),
                $request->getVersion(),
                $request->getOneWay()
            );
        });

        $modifiedRequest = $encoder->encode('method', ['arg']);

        self::assertTrue($invoked);
        self::assertSame('<modified/>', $modifiedRequest->getRequest());
    }
}
