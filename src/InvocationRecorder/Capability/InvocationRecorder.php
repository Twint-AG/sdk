<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Capability;

use Twint\Sdk\Capability\Capability;
use Twint\Sdk\InvocationRecorder\Value\Invocation;

interface InvocationRecorder extends Capability
{
    /**
     * @return list<Invocation>
     */
    public function flushInvocations(): array;
}
