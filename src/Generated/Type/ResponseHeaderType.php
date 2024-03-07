<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class ResponseHeaderType
{
    /**
     * @var string
     */
    private $MessageId;

    /**
     * @return string
     */
    public function getMessageId()
    {
        return $this->MessageId;
    }

    /**
     * @param string $MessageId
     * @return ResponseHeaderType
     */
    public function withMessageId($MessageId)
    {
        $new = clone $this;
        $new->MessageId = $MessageId;

        return $new;
    }
}
