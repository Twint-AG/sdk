<?php

namespace Twint\Sdk\Generated;

use Twint\Sdk\Generated\Type;
use Phpro\SoapClient\Type\ResultInterface;
use Phpro\SoapClient\Exception\SoapException;
use Phpro\SoapClient\Type\RequestInterface;

class TwintClient extends \Phpro\SoapClient\Client
{
    /**
     * @param RequestInterface|Type\RequestCheckInRequestType $request
     * @return ResultInterface|Type\RequestCheckInResponseType
     * @throws SoapException
     */
    public function requestCheckIn(\Twint\Sdk\Generated\Type\RequestCheckInRequestType $request) : \Twint\Sdk\Generated\Type\RequestCheckInResponseType
    {
        return $this->call('RequestCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorCheckInRequestType $request
     * @return ResultInterface|Type\MonitorCheckInResponseType
     * @throws SoapException
     */
    public function monitorCheckIn(\Twint\Sdk\Generated\Type\MonitorCheckInRequestType $request) : \Twint\Sdk\Generated\Type\MonitorCheckInResponseType
    {
        return $this->call('MonitorCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\IsUofConnectionActiveRequestType $request
     * @return ResultInterface|Type\IsUofConnectionActiveResponseType
     * @throws SoapException
     */
    public function isUofConnectionActive(\Twint\Sdk\Generated\Type\IsUofConnectionActiveRequestType $request) : \Twint\Sdk\Generated\Type\IsUofConnectionActiveResponseType
    {
        return $this->call('IsUofConnectionActive', $request);
    }

    /**
     * @param RequestInterface|Type\CancelCheckInRequestType $request
     * @return ResultInterface|Type\CancelCheckInResponseType
     * @throws SoapException
     */
    public function cancelCheckIn(\Twint\Sdk\Generated\Type\CancelCheckInRequestType $request) : \Twint\Sdk\Generated\Type\CancelCheckInResponseType
    {
        return $this->call('CancelCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\StartOrderRequestType $request
     * @return ResultInterface|Type\StartOrderResponseType
     * @throws SoapException
     */
    public function startOrder(\Twint\Sdk\Generated\Type\StartOrderRequestType $request) : \Twint\Sdk\Generated\Type\StartOrderResponseType
    {
        return $this->call('StartOrder', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorOrderRequestType $request
     * @return ResultInterface|Type\MonitorOrderResponseType
     * @throws SoapException
     */
    public function monitorOrder(\Twint\Sdk\Generated\Type\MonitorOrderRequestType $request) : \Twint\Sdk\Generated\Type\MonitorOrderResponseType
    {
        return $this->call('MonitorOrder', $request);
    }

    /**
     * @param RequestInterface|Type\ConfirmOrderRequestType $request
     * @return ResultInterface|Type\ConfirmOrderResponseType
     * @throws SoapException
     */
    public function confirmOrder(\Twint\Sdk\Generated\Type\ConfirmOrderRequestType $request) : \Twint\Sdk\Generated\Type\ConfirmOrderResponseType
    {
        return $this->call('ConfirmOrder', $request);
    }

    /**
     * @param RequestInterface|Type\CancelOrderRequestType $request
     * @return ResultInterface|Type\CancelOrderResponseType
     * @throws SoapException
     */
    public function cancelOrder(\Twint\Sdk\Generated\Type\CancelOrderRequestType $request) : \Twint\Sdk\Generated\Type\CancelOrderResponseType
    {
        return $this->call('CancelOrder', $request);
    }

    /**
     * @param RequestInterface|Type\FindOrderRequestType $request
     * @return ResultInterface|Type\FindOrderResponseType
     * @throws SoapException
     */
    public function findOrder(\Twint\Sdk\Generated\Type\FindOrderRequestType $request) : \Twint\Sdk\Generated\Type\FindOrderResponseType
    {
        return $this->call('FindOrder', $request);
    }

    /**
     * @param RequestInterface|Type\EnrollCashRegisterRequestType $request
     * @return ResultInterface|Type\EnrollCashRegisterResponseType
     * @throws SoapException
     */
    public function enrollCashRegister(\Twint\Sdk\Generated\Type\EnrollCashRegisterRequestType $request) : \Twint\Sdk\Generated\Type\EnrollCashRegisterResponseType
    {
        return $this->call('EnrollCashRegister', $request);
    }

    /**
     * @param RequestInterface|Type\CheckSystemStatusRequestType $request
     * @return ResultInterface|Type\CheckSystemStatusResponseType
     * @throws SoapException
     */
    public function checkSystemStatus(\Twint\Sdk\Generated\Type\CheckSystemStatusRequestType $request) : \Twint\Sdk\Generated\Type\CheckSystemStatusResponseType
    {
        return $this->call('CheckSystemStatus', $request);
    }

    /**
     * @param RequestInterface|Type\GetCertificateValidityRequestType $request
     * @return ResultInterface|Type\GetCertificateValidityResponseType
     * @throws SoapException
     */
    public function getCertificateValidity(\Twint\Sdk\Generated\Type\GetCertificateValidityRequestType $request) : \Twint\Sdk\Generated\Type\GetCertificateValidityResponseType
    {
        return $this->call('GetCertificateValidity', $request);
    }

    /**
     * @param RequestInterface|Type\RenewCertificateRequestType $request
     * @return ResultInterface|Type\RenewCertificateResponseType
     * @throws SoapException
     */
    public function renewCertificate(\Twint\Sdk\Generated\Type\RenewCertificateRequestType $request) : \Twint\Sdk\Generated\Type\RenewCertificateResponseType
    {
        return $this->call('RenewCertificate', $request);
    }

    /**
     * @param RequestInterface|Type\GetOrderRequestType $request
     * @return ResultInterface|Type\GetOrderResponseType
     * @throws SoapException
     */
    public function getOrder(\Twint\Sdk\Generated\Type\GetOrderRequestType $request) : \Twint\Sdk\Generated\Type\GetOrderResponseType
    {
        return $this->call('GetOrder', $request);
    }

    /**
     * @param RequestInterface|Type\StartOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\StartOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function startOrderAndUofRegistration(\Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationRequestType $request) : \Twint\Sdk\Generated\Type\StartOrderAndUofRegistrationResponseType
    {
        return $this->call('StartOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\MonitorOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function monitorOrderAndUofRegistration(\Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationRequestType $request) : \Twint\Sdk\Generated\Type\MonitorOrderAndUofRegistrationResponseType
    {
        return $this->call('MonitorOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\ConfirmOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\ConfirmOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function confirmOrderAndUofRegistration(\Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationRequestType $request) : \Twint\Sdk\Generated\Type\ConfirmOrderAndUofRegistrationResponseType
    {
        return $this->call('ConfirmOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\CancelOrderAndUofRegistrationRequestType $request
     * @return ResultInterface|Type\CancelOrderAndUofRegistrationResponseType
     * @throws SoapException
     */
    public function cancelOrderAndUofRegistration(\Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationRequestType $request) : \Twint\Sdk\Generated\Type\CancelOrderAndUofRegistrationResponseType
    {
        return $this->call('CancelOrderAndUofRegistration', $request);
    }

    /**
     * @param RequestInterface|Type\RequestFastCheckoutCheckInRequestType $request
     * @return ResultInterface|Type\RequestFastCheckoutCheckInResponseType
     * @throws SoapException
     */
    public function requestFastCheckoutCheckIn(\Twint\Sdk\Generated\Type\RequestFastCheckoutCheckInRequestType $request) : \Twint\Sdk\Generated\Type\RequestFastCheckoutCheckInResponseType
    {
        return $this->call('RequestFastCheckoutCheckIn', $request);
    }

    /**
     * @param RequestInterface|Type\MonitorFastCheckoutCheckInRequestType $request
     * @return ResultInterface|Type\MonitorFastCheckoutCheckInResponseType
     * @throws SoapException
     */
    public function monitorFastCheckoutCheckIn(\Twint\Sdk\Generated\Type\MonitorFastCheckoutCheckInRequestType $request) : \Twint\Sdk\Generated\Type\MonitorFastCheckoutCheckInResponseType
    {
        return $this->call('MonitorFastCheckoutCheckIn', $request);
    }
}

