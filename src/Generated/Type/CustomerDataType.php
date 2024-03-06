<?php

namespace Twint\Sdk\Generated\Type;

class CustomerDataType
{
    /**
     * @var \Twint\Sdk\Generated\Type\CustomerDataFieldType
     */
    private $Field;

    /**
     * @return \Twint\Sdk\Generated\Type\CustomerDataFieldType
     */
    public function getField()
    {
        return $this->Field;
    }

    /**
     * @param \Twint\Sdk\Generated\Type\CustomerDataFieldType $Field
     * @return CustomerDataType
     */
    public function withField($Field)
    {
        $new = clone $this;
        $new->Field = $Field;

        return $new;
    }
}

