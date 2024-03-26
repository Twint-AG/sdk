<?php

declare(strict_types=1);

namespace Twint\Sdk\Checks\PHPUnit;

use Attribute;
use Closure;
use VCR\Request;

#[Attribute(Attribute::TARGET_METHOD)]
final class Vcr
{
    public readonly ?Closure $censorRequest;

    public readonly ?Closure $censorResponse;

    /**
     * @param int<0, max> $fixtureRevision
     * @param list<'method'|'url'|'host'|'headers'|'body'|'post_fields'|'query_string'|'soap_operation'> $requestMatchers
     * @param callable(Request): void|null $censorRequest
     * @param callable(MutableResponse): void|null $censorResponse
     */
    public function __construct(
        public readonly int $fixtureRevision,
        public readonly array $requestMatchers,
        ?callable $censorRequest = null,
        ?callable $censorResponse = null
    ) {
        $this->censorRequest = $censorRequest !== null ? $censorRequest(...) : null;
        $this->censorResponse = $censorResponse !== null ? $censorResponse(...) : null;
    }
}
