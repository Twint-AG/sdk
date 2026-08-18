<?php

declare(strict_types=1);

namespace Twint\Sdk\Tools\Hermeticism;

use Override;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;
use Throwable;

/**
 * Records what the real TWINT API actually returned.
 *
 * ext-soap reports any non-XML response as "looks like we got no XML document", which hides
 * the status code and body that would explain it. Those responses only ever happen in the
 * empirical lane, and the SOAP-level recorder in InvocationRecorder cannot see the status code,
 * so the PSR-18 layer is the only place the evidence is available.
 *
 * One JSON object per line, because a response body can contain anything -- newlines, or a
 * line that looks like whatever delimiter a plain-text format would use -- and the log is
 * worth filtering:
 *
 *     jq -r 'select(.status != 200) | .body' build/empirical-responses.log
 *
 * Request bodies are deliberately not logged: the response is what is in question, and the
 * request adds merchant data to the log without adding evidence.
 */
final class LoggingHttpClient implements ClientInterface
{
    private const MAX_BODY_LENGTH = 4096;

    public function __construct(
        private readonly ClientInterface $client,
        private readonly string $path
    ) {
    }

    /**
     * @throws ClientExceptionInterface
     * @throws RuntimeException
     */
    #[Override]
    public function sendRequest(RequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->client->sendRequest($request);
        } catch (Throwable $e) {
            $this->append($request, [
                'exception' => $e::class,
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }

        $this->append($request, [
            'status' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'contentType' => self::header($response, 'content-type'),
            'body' => self::body($response),
        ]);

        return $response;
    }

    /**
     * Reading the body consumes the stream, so it is only safe to look at one that can be
     * rewound for the SOAP decoder that reads it next.
     *
     * @throws RuntimeException
     */
    private static function body(ResponseInterface $response): string
    {
        $body = $response->getBody();

        if (!$body->isSeekable()) {
            return '<body is not seekable, not read>';
        }

        $content = (string) $body;
        $body->rewind();

        $length = strlen($content);

        if ($length <= self::MAX_BODY_LENGTH) {
            return $content;
        }

        return substr($content, 0, self::MAX_BODY_LENGTH)
            . sprintf("\n... [%d of %d bytes truncated]", $length - self::MAX_BODY_LENGTH, $length);
    }

    private static function header(MessageInterface $message, string $name): ?string
    {
        $values = $message->getHeader($name);

        return $values === [] ? null : implode(', ', $values);
    }

    /**
     * @param array<string, scalar|null> $outcome
     */
    private function append(RequestInterface $request, array $outcome): void
    {
        $entry = json_encode(
            [
                'method' => $request->getMethod(),
                'uri' => (string) $request->getUri(),
                'soapAction' => self::header($request, 'SOAPAction'),
                ...$outcome,
            ],
            // A response body is not guaranteed to be valid UTF-8, and a logger that throws
            // while recording a failure is worse than a lossy one.
            JSON_INVALID_UTF8_SUBSTITUTE | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );

        if ($entry === false) {
            return;
        }

        file_put_contents($this->path, $entry . "\n", FILE_APPEND);
    }
}
