<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated;

use Phpro\SoapClient\Caller\Caller;
use Phpro\SoapClient\Exception\SoapException;
use Phpro\SoapClient\Type\RequestInterface;
use Phpro\SoapClient\Type\ResultInterface;
use Twint\Sdk\Generated\Type\CancelCheckInRequestElement;
use Twint\Sdk\Generated\Type\CancelCheckInResponseType;
use Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationRequestElement;
use Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\CancelOrderRequestElement;
use Twint\Sdk\Generated\Type\CancelOrderResponseType;
use Twint\Sdk\Generated\Type\CheckSystemStatusRequestElement;
use Twint\Sdk\Generated\Type\CheckSystemStatusResponseType;
use Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationRequestElement;
use Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\ConfirmOrderRequestElement;
use Twint\Sdk\Generated\Type\ConfirmOrderResponseType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestElement;
use Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType;
use Twint\Sdk\Generated\Type\FindOrderRequestElement;
use Twint\Sdk\Generated\Type\FindOrderResponseType;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestElement;
use Twint\Sdk\Generated\Type\GetCertificateValidityResponseType;
use Twint\Sdk\Generated\Type\GetOrderRequestElement;
use Twint\Sdk\Generated\Type\GetOrderResponseType;
use Twint\Sdk\Generated\Type\IsUofConnectionActiveRequestElement;
use Twint\Sdk\Generated\Type\IsUofConnectionActiveResponseType;
use Twint\Sdk\Generated\Type\MonitorCheckInRequestElement;
use Twint\Sdk\Generated\Type\MonitorCheckInResponseType;
use Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationRequestElement;
use Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\MonitorOrderRequestElement;
use Twint\Sdk\Generated\Type\MonitorOrderResponseType;
use Twint\Sdk\Generated\Type\RenewCertificateRequestElement;
use Twint\Sdk\Generated\Type\RenewCertificateResponseType;
use Twint\Sdk\Generated\Type\RequestCheckInRequestElement;
use Twint\Sdk\Generated\Type\RequestCheckInResponseType;
use Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationRequestElement;
use Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\StartOrderRequestElement;
use Twint\Sdk\Generated\Type\StartOrderResponseType;
use function Psl\Type\instance_of;

class TwintSoapClient
{
    /**
     * @var Caller
     */
    private $caller;

    public function __construct(Caller $caller)
    {
        $this->caller = $caller;
    }

    /**
     * @param RequestInterface & Type\RequestCheckInRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\RequestCheckInResponseType
     */
    public function requestCheckIn(RequestCheckInRequestElement $request): RequestCheckInResponseType
    {
        $response = ($this->caller)('RequestCheckIn', $request);

        instance_of(RequestCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorCheckInRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\MonitorCheckInResponseType
     */
    public function monitorCheckIn(MonitorCheckInRequestElement $request): MonitorCheckInResponseType
    {
        $response = ($this->caller)('MonitorCheckIn', $request);

        instance_of(MonitorCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\IsUofConnectionActiveRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\IsUofConnectionActiveResponseType
     */
    public function isUofConnectionActive(
        IsUofConnectionActiveRequestElement $request
    ): IsUofConnectionActiveResponseType {
        $response = ($this->caller)('IsUofConnectionActive', $request);

        instance_of(IsUofConnectionActiveResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelCheckInRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\CancelCheckInResponseType
     */
    public function cancelCheckIn(CancelCheckInRequestElement $request): CancelCheckInResponseType
    {
        $response = ($this->caller)('CancelCheckIn', $request);

        instance_of(CancelCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\StartOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\StartOrderResponseType
     */
    public function startOrder(StartOrderRequestElement $request): StartOrderResponseType
    {
        $response = ($this->caller)('StartOrder', $request);

        instance_of(StartOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\MonitorOrderResponseType
     */
    public function monitorOrder(MonitorOrderRequestElement $request): MonitorOrderResponseType
    {
        $response = ($this->caller)('MonitorOrder', $request);

        instance_of(MonitorOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\ConfirmOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\ConfirmOrderResponseType
     */
    public function confirmOrder(ConfirmOrderRequestElement $request): ConfirmOrderResponseType
    {
        $response = ($this->caller)('ConfirmOrder', $request);

        instance_of(ConfirmOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\CancelOrderResponseType
     */
    public function cancelOrder(CancelOrderRequestElement $request): CancelOrderResponseType
    {
        $response = ($this->caller)('CancelOrder', $request);

        instance_of(CancelOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\FindOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\FindOrderResponseType
     */
    public function findOrder(FindOrderRequestElement $request): FindOrderResponseType
    {
        $response = ($this->caller)('FindOrder', $request);

        instance_of(FindOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\EnrollCashRegisterRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\EnrollCashRegisterResponseType
     */
    public function enrollCashRegister(EnrollCashRegisterRequestElement $request): EnrollCashRegisterResponseType
    {
        $response = ($this->caller)('EnrollCashRegister', $request);

        instance_of(EnrollCashRegisterResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CheckSystemStatusRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\CheckSystemStatusResponseType
     */
    public function checkSystemStatus(CheckSystemStatusRequestElement $request): CheckSystemStatusResponseType
    {
        $response = ($this->caller)('CheckSystemStatus', $request);

        instance_of(CheckSystemStatusResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\GetCertificateValidityRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\GetCertificateValidityResponseType
     */
    public function getCertificateValidity(
        GetCertificateValidityRequestElement $request
    ): GetCertificateValidityResponseType {
        $response = ($this->caller)('GetCertificateValidity', $request);

        instance_of(GetCertificateValidityResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\RenewCertificateRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\RenewCertificateResponseType
     */
    public function renewCertificate(RenewCertificateRequestElement $request): RenewCertificateResponseType
    {
        $response = ($this->caller)('RenewCertificate', $request);

        instance_of(RenewCertificateResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\GetOrderRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\GetOrderResponseType
     */
    public function getOrder(GetOrderRequestElement $request): GetOrderResponseType
    {
        $response = ($this->caller)('GetOrder', $request);

        instance_of(GetOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\StartOrderAndUofRegistrationRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\StartOrderAndUofRegistrationResponseType
     */
    public function startOrderAndUofRegistration(
        StartOrderAndUofRegistrationRequestElement $request
    ): StartOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('StartOrderAndUofRegistration', $request);

        instance_of(StartOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorOrderAndUofRegistrationRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\MonitorOrderAndUofRegistrationResponseType
     */
    public function monitorOrderAndUofRegistration(
        MonitorOrderAndUofRegistrationRequestElement $request
    ): MonitorOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('MonitorOrderAndUofRegistration', $request);

        instance_of(MonitorOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\ConfirmOrderAndUofRegistrationRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\ConfirmOrderAndUofRegistrationResponseType
     */
    public function confirmOrderAndUofRegistration(
        ConfirmOrderAndUofRegistrationRequestElement $request
    ): ConfirmOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('ConfirmOrderAndUofRegistration', $request);

        instance_of(ConfirmOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelOrderAndUofRegistrationRequestElement $request
     * @throws SoapException
     * @return ResultInterface & Type\CancelOrderAndUofRegistrationResponseType
     */
    public function cancelOrderAndUofRegistration(
        CancelOrderAndUofRegistrationRequestElement $request
    ): CancelOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('CancelOrderAndUofRegistration', $request);

        instance_of(CancelOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }
}
