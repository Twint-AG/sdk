<?php

namespace Twint\Sdk\Generated\Type;

class KeyValueType
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

    /**
     * @param string $_
     * @return KeyValueType
     */
    public function with_($_)
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

    /**
     * @param string $key
     * @return KeyValueType
     */
    public function withKey($key)
    {
        $new = clone $this;
        $new->key = $key;

        return $new;
    }
}

