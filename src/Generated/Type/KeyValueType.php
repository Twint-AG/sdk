<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

final class KeyValueType
{
    /**
     * @var string
     */
    private $_;

    /**
     * @var string
     */
    private $key;

    /**
     * @return string
     */
    public function get_()
    {
        return $this->_;
    }

    public function with_(string $_): self
    {
        $new = clone $this;
        $new->_ = $_;

        return $new;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public function withKey(string $key): self
    {
        $new = clone $this;
        $new->key = $key;

        return $new;
    }
}
