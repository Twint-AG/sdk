<?php

namespace Twint\Sdk\Generated\Type;

class ResponseHeaderType
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

