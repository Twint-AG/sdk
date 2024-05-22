<?php

declare(strict_types=1);

namespace Twint\Sdk\InvocationRecorder\Soap;

use Twint\Sdk\InvocationRecorder\Value\SoapMessage;

final class MessageRecorder
{
    /**
     * @var list<SoapMessage>
     */
    private array $messages = [];

    public function record(SoapMessage $message): void
    {
        $this->messages[] = $message;
    }

    /**
     * @return list<SoapMessage>
     */
    public function flush(): array
    {
        try {
            return $this->messages;
        } finally {
            $this->messages = [];
        }
    }
}
