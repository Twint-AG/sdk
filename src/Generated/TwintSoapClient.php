<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated;

use Phpro\SoapClient\Caller\Caller;
use Phpro\SoapClient\Exception\SoapException;
use Phpro\SoapClient\Type\RequestInterface;
use Phpro\SoapClient\Type\ResultInterface;
use Twint\Sdk\Generated\Type\CancelCheckInRequestType;
use Twint\Sdk\Generated\Type\CancelCheckInResponseType;
use Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationRequestType;
use Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\CancelOrderRequestType;
use Twint\Sdk\Generated\Type\CancelOrderResponseType;
use Twint\Sdk\Generated\Type\CheckSystemStatusRequestType;
use Twint\Sdk\Generated\Type\CheckSystemStatusResponseType;
use Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationRequestType;
use Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\ConfirmOrderRequestType;
use Twint\Sdk\Generated\Type\ConfirmOrderResponseType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterRequestType;
use Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType;
use Twint\Sdk\Generated\Type\FindOrderRequestType;
use Twint\Sdk\Generated\Type\FindOrderResponseType;
use Twint\Sdk\Generated\Type\GetCertificateValidityRequestType;
use Twint\Sdk\Generated\Type\GetCertificateValidityResponseType;
use Twint\Sdk\Generated\Type\GetOrderRequestType;
use Twint\Sdk\Generated\Type\GetOrderResponseType;
use Twint\Sdk\Generated\Type\IsUofConnectionActiveRequestType;
use Twint\Sdk\Generated\Type\IsUofConnectionActiveResponseType;
use Twint\Sdk\Generated\Type\MonitorCheckInRequestType;
use Twint\Sdk\Generated\Type\MonitorCheckInResponseType;
use Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationRequestType;
use Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\MonitorOrderRequestType;
use Twint\Sdk\Generated\Type\MonitorOrderResponseType;
use Twint\Sdk\Generated\Type\RenewCertificateRequestType;
use Twint\Sdk\Generated\Type\RenewCertificateResponseType;
use Twint\Sdk\Generated\Type\RequestCheckInRequestType;
use Twint\Sdk\Generated\Type\RequestCheckInResponseType;
use Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationRequestType;
use Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationResponseType;
use Twint\Sdk\Generated\Type\StartOrderRequestType;
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
     * @param RequestInterface & Type\RequestCheckInRequestType $request
     * @return ResultInterface & Type\RequestCheckInResponseType
     * @throws SoapException
     */
    public function requestCheckIn(RequestCheckInRequestType $request): RequestCheckInResponseType
    {
        $response = ($this->caller)('RequestCheckIn', $request);

        instance_of(RequestCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorCheckInRequestType $request
     * @return ResultInterface & Type\MonitorCheckInResponseType
     * @throws SoapException
     */
    public function monitorCheckIn(MonitorCheckInRequestType $request): MonitorCheckInResponseType
    {
        $response = ($this->caller)('MonitorCheckIn', $request);

        instance_of(MonitorCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\IsUofConnectionActiveRequestType $request
     * @return ResultInterface & Type\IsUofConnectionActiveResponseType
     * @throws SoapException
     */
    public function isUofConnectionActive(IsUofConnectionActiveRequestType $request): IsUofConnectionActiveResponseType
    {
        $response = ($this->caller)('IsUofConnectionActive', $request);

        instance_of(IsUofConnectionActiveResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelCheckInRequestType $request
     * @return ResultInterface & Type\CancelCheckInResponseType
     * @throws SoapException
     */
    public function cancelCheckIn(CancelCheckInRequestType $request): CancelCheckInResponseType
    {
        $response = ($this->caller)('CancelCheckIn', $request);

        instance_of(CancelCheckInResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\StartOrderRequestType $request
     * @return ResultInterface & Type\StartOrderResponseType
     * @throws SoapException
     */
    public function startOrder(StartOrderRequestType $request): StartOrderResponseType
    {
        $response = ($this->caller)('StartOrder', $request);

        instance_of(StartOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorOrderRequestType $request
     * @return ResultInterface & Type\MonitorOrderResponseType
     * @throws SoapException
     */
    public function monitorOrder(MonitorOrderRequestType $request): MonitorOrderResponseType
    {
        $response = ($this->caller)('MonitorOrder', $request);

        instance_of(MonitorOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\ConfirmOrderRequestType $request
     * @return ResultInterface & Type\ConfirmOrderResponseType
     * @throws SoapException
     */
    public function confirmOrder(ConfirmOrderRequestType $request): ConfirmOrderResponseType
    {
        $response = ($this->caller)('ConfirmOrder', $request);

        instance_of(ConfirmOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelOrderRequestType $request
     * @return ResultInterface & Type\CancelOrderResponseType
     * @throws SoapException
     */
    public function cancelOrder(CancelOrderRequestType $request): CancelOrderResponseType
    {
        $response = ($this->caller)('CancelOrder', $request);

        instance_of(CancelOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\FindOrderRequestType $request
     * @return ResultInterface & Type\FindOrderResponseType
     * @throws SoapException
     */
    public function findOrder(FindOrderRequestType $request): FindOrderResponseType
    {
        $response = ($this->caller)('FindOrder', $request);

        instance_of(FindOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\EnrollCashRegisterRequestType $request
     * @return ResultInterface & Type\EnrollCashRegisterResponseType
     * @throws SoapException
     */
    public function enrollCashRegister(EnrollCashRegisterRequestType $request): EnrollCashRegisterResponseType
    {
        $response = ($this->caller)('EnrollCashRegister', $request);

        instance_of(EnrollCashRegisterResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CheckSystemStatusRequestType $request
     * @return ResultInterface & Type\CheckSystemStatusResponseType
     * @throws SoapException
     */
    public function checkSystemStatus(CheckSystemStatusRequestType $request): CheckSystemStatusResponseType
    {
        $response = ($this->caller)('CheckSystemStatus', $request);

        instance_of(CheckSystemStatusResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\GetCertificateValidityRequestType $request
     * @return ResultInterface & Type\GetCertificateValidityResponseType
     * @throws SoapException
     */
    public function getCertificateValidity(
        GetCertificateValidityRequestType $request
    ): GetCertificateValidityResponseType {
        $response = ($this->caller)('GetCertificateValidity', $request);

        instance_of(GetCertificateValidityResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\RenewCertificateRequestType $request
     * @return ResultInterface & Type\RenewCertificateResponseType
     * @throws SoapException
     */
    public function renewCertificate(RenewCertificateRequestType $request): RenewCertificateResponseType
    {
        $response = ($this->caller)('RenewCertificate', $request);

        instance_of(RenewCertificateResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\GetOrderRequestType $request
     * @return ResultInterface & Type\GetOrderResponseType
     * @throws SoapException
     */
    public function getOrder(GetOrderRequestType $request): GetOrderResponseType
    {
        $response = ($this->caller)('GetOrder', $request);

        instance_of(GetOrderResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\StartOrderAndUofRegistrationRequestType $request
     * @return ResultInterface & Type\StartOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function startOrderAndUofRegistration(
        StartOrderAndUofRegistrationRequestType $request
    ): StartOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('StartOrderAndUofRegistration', $request);

        instance_of(StartOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\MonitorOrderAndUofRegistrationRequestType $request
     * @return ResultInterface & Type\MonitorOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function monitorOrderAndUofRegistration(
        MonitorOrderAndUofRegistrationRequestType $request
    ): MonitorOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('MonitorOrderAndUofRegistration', $request);

        instance_of(MonitorOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\ConfirmOrderAndUofRegistrationRequestType $request
     * @return ResultInterface & Type\ConfirmOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function confirmOrderAndUofRegistration(
        ConfirmOrderAndUofRegistrationRequestType $request
    ): ConfirmOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('ConfirmOrderAndUofRegistration', $request);

        instance_of(ConfirmOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }

    /**
     * @param RequestInterface & Type\CancelOrderAndUofRegistrationRequestType $request
     * @return ResultInterface & Type\CancelOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function cancelOrderAndUofRegistration(
        CancelOrderAndUofRegistrationRequestType $request
    ): CancelOrderAndUofRegistrationResponseType {
        $response = ($this->caller)('CancelOrderAndUofRegistration', $request);

        instance_of(CancelOrderAndUofRegistrationResponseType::class)->assert($response);
        instance_of(ResultInterface::class)->assert($response);

        return $response;
    }
}
