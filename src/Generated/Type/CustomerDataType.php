<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class CustomerDataType
{
    /**
     * @var non-empty-array<int<0, max>, CustomerDataFieldType>
     */
    protected array $Field;

    /**
     * @return non-empty-array<int<0, max>, CustomerDataFieldType>
     */
    public function getField(): array
    {
        return $this->Field;
    }

    /**
     * @param non-empty-array<int<0, max>, CustomerDataFieldType> $Field
     */
    public function withField(array $Field): static
    {
        $new = clone $this;
        $new->Field = $Field;

        return $new;
    }
}
