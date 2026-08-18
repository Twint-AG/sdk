<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated\Type;

use Phpro\SoapClient\Type\ResultInterface;

class EnrollCashRegisterResponseType implements ResultInterface
{
    /**
     * The MessageHeader is a common type used to identify conversations between participants in this interface and to uniquely mark those conversations with basic data like
     *  an Id and timestamps. This information can be used by the receiving party of the message for protocol features as duplicate detection.
     */
    protected MessageHeaderType $MessageHeader;

    /**
     * Reference to the Merchant the given Terminals belong to
     */
    protected MerchantReferenceType $MerchantReference;

    /**
     * List of Terminals to be inserted or updated for the given Merchant Reference with a potential status;
     *  UUID will be filled in if existing, otherwise TerminalExternalId will be used.
     *
     * @var non-empty-array<int<0, max>, TerminalReferenceWithStatusType>
     */
    protected array $Terminal;

    public function getMessageHeader(): MessageHeaderType
    {
        return $this->MessageHeader;
    }

    public function withMessageHeader(MessageHeaderType $MessageHeader): static
    {
        $new = clone $this;
        $new->MessageHeader = $MessageHeader;

        return $new;
    }

    public function getMerchantReference(): MerchantReferenceType
    {
        return $this->MerchantReference;
    }

    public function withMerchantReference(MerchantReferenceType $MerchantReference): static
    {
        $new = clone $this;
        $new->MerchantReference = $MerchantReference;

        return $new;
    }

    /**
     * @return non-empty-array<int<0, max>, TerminalReferenceWithStatusType>
     */
    public function getTerminal(): array
    {
        return $this->Terminal;
    }

    /**
     * @param non-empty-array<int<0, max>, TerminalReferenceWithStatusType> $Terminal
     */
    public function withTerminal(array $Terminal): static
    {
        $new = clone $this;
        $new->Terminal = $Terminal;

        return $new;
    }
}
