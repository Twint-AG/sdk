<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

class InternationalizedString
{
    protected string $_;

    /**
     * @var 'de' | 'fr' | 'it' | 'en'
     */
    protected string $language;

    public function get_(): string
    {
        return $this->_;
    }

    public function with_(string $_): static
    {
        $new = clone $this;
        $new->_ = $_;

        return $new;
    }

    /**
     * @return 'de' | 'fr' | 'it' | 'en'
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param 'de' | 'fr' | 'it' | 'en' $language
     */
    public function withLanguage(string $language): static
    {
        $new = clone $this;
        $new->language = $language;

        return $new;
    }
}
