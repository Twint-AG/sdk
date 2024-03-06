<?php

namespace Twint\Sdk\Generated\Type;

class CustomerDataFieldType
{
    /**
     * @var string
     */
    private $Name;

    /**
     * @var string
     */
    private $Value;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->Name;
    }

    /**
     * @param string $Name
     * @return CustomerDataFieldType
     */
    public function withName($Name)
    {
        $new = clone $this;
        $new->Name = $Name;

        return $new;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->Value;
    }

    /**
     * @param string $Value
     * @return CustomerDataFieldType
     */
    public function withValue($Value)
    {
        $new = clone $this;
        $new->Value = $Value;

        return $new;
    }
}

