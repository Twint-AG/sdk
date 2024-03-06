<?php

namespace Twint\Sdk\Generated\Type;

class InternationalizedString
{
    /**
     * @var string
     */
    private $_;

    /**
     * @var string
     */
    private $language;

    /**
     * @return string
     */
    public function get_()
    {
        return $this->_;
    }

    /**
     * @param string $_
     * @return InternationalizedString
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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return InternationalizedString
     */
    public function withLanguage($language)
    {
        $new = clone $this;
        $new->language = $language;

        return $new;
    }
}

