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

final class TwintSoapClient
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
     * @param RequestInterface|Type\RequestCheckInRequestType $request
     * @return ResultInterface|Type\RequestCheckInResponseType
     * @throws SoapException
     */
    public function requestCheckIn(RequestCheckInRequestType $request): RequestCheckInResponseType
    {
        return ($this->caller)('RequestCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorCheckInRequestType $request
     * @return ResultInterface|Type\MonitorCheckInResponseType
     * @throws SoapException
     */
    public function monitorCheckIn(MonitorCheckInRequestType $request): MonitorCheckInResponseType
    {
        return ($this->caller)('MonitorCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\IsUofConnectionActiveRequestType $request
     * @return ResultInterface|Type\IsUofConnectionActiveResponseType
     * @throws SoapException
     */
    public function isUofConnectionActive(IsUofConnectionActiveRequestType $request): IsUofConnectionActiveResponseType
    {
        return ($this->caller)('IsUofConnectionActive', $request);
    }

    /**
     * @param RequestInterface|Type\CancelCheckInRequestType $request
     * @return ResultInterface|Type\CancelCheckInResponseType
     * @throws SoapException
     */
    public function cancelCheckIn(CancelCheckInRequestType $request): CancelCheckInResponseType
    {
        return ($this->caller)('CancelCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\StartOrderRequestType $request
     * @return ResultInterface|Type\StartOrderResponseType
     * @throws SoapException
     */
    public function startOrder(StartOrderRequestType $request): StartOrderResponseType
    {
        return ($this->caller)('StartOrder', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorOrderRequestType $request
     * @return ResultInterface|Type\MonitorOrderResponseType
     * @throws SoapException
     */
    public function monitorOrder(MonitorOrderRequestType $request): MonitorOrderResponseType
    {
        return ($this->caller)('MonitorOrder', $request);
    }

    /**
     * @param RequestInterface|Type\ConfirmOrderRequestType $request
     * @return ResultInterface|Type\ConfirmOrderResponseType
     * @throws SoapException
     */
    public function confirmOrder(ConfirmOrderRequestType $request): ConfirmOrderResponseType
    {
        return ($this->caller)('ConfirmOrder', $request);
    }

    /**
     * @param RequestInterface|Type\CancelOrderRequestType $request
     * @return ResultInterface|Type\CancelOrderResponseType
     * @throws SoapException
     */
    public function cancelOrder(CancelOrderRequestType $request): CancelOrderResponseType
    {
        return ($this->caller)('CancelOrder', $request);
    }

    /**
     * @param RequestInterface|Type\FindOrderRequestType $request
     * @return ResultInterface|Type\FindOrderResponseType
     * @throws SoapException
     */
    public function findOrder(FindOrderRequestType $request): FindOrderResponseType
    {
        return ($this->caller)('FindOrder', $request);
    }

    /**
     * @param RequestInterface|Type\EnrollCashRegisterRequestType $request
     * @return ResultInterface|Type\EnrollCashRegisterResponseType
     * @throws SoapException
     */
    public function enrollCashRegister(EnrollCashRegisterRequestType $request): EnrollCashRegisterResponseType
    {
        return ($this->caller)('EnrollCashRegister', $request);
    }

    /**
     * @param RequestInterface|Type\CheckSystemStatusRequestType $request
     * @return ResultInterface|Type\CheckSystemStatusResponseType
     * @throws SoapException
     */
    public function checkSystemStatus(CheckSystemStatusRequestType $request): CheckSystemStatusResponseType
    {
        return ($this->caller)('CheckSystemStatus', $request);
    }

    /**
     * @param RequestInterface|Type\GetCertificateValidityRequestType $request
     * @return ResultInterface|Type\GetCertificateValidityResponseType
     * @throws SoapException
     */
    public function getCertificateValidity(
        GetCertificateValidityRequestType $request
    ): GetCertificateValidityResponseType {
        return ($this->caller)('GetCertificateValidity', $request);
    }

    /**
     * @param RequestInterface|Type\RenewCertificateRequestType $request
     * @return ResultInterface|Type\RenewCertificateResponseType
     * @throws SoapException
     */
    public function renewCertificate(RenewCertificateRequestType $request): RenewCertificateResponseType
    {
        return ($this->caller)('RenewCertificate', $request);
    }

    /**
     * @param RequestInterface|Type\GetOrderRequestType $request
     * @return ResultInterface|Type\GetOrderResponseType
     * @throws SoapException
     */
    public function getOrder(GetOrderRequestType $request): GetOrderResponseType
    {
        return ($this->caller)('GetOrder', $request);
    }

    /**
     * @param RequestInterface|Type\StartOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\StartOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function startOrderAndUofRegistration(
        StartOrderAndUofRegistrationRequestType $request
    ): StartOrderAndUofRegistrationResponseType {
        return ($this->caller)('StartOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\MonitorOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function monitorOrderAndUofRegistration(
        MonitorOrderAndUofRegistrationRequestType $request
    ): MonitorOrderAndUofRegistrationResponseType {
        return ($this->caller)('MonitorOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\ConfirmOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\ConfirmOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function confirmOrderAndUofRegistration(
        ConfirmOrderAndUofRegistrationRequestType $request
    ): ConfirmOrderAndUofRegistrationResponseType {
        return ($this->caller)('ConfirmOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\CancelOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\CancelOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function cancelOrderAndUofRegistration(
        CancelOrderAndUofRegistrationRequestType $request
    ): CancelOrderAndUofRegistrationResponseType {
        return ($this->caller)('CancelOrderAndUofRegistration', $request);
    }
}
