<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated;

use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMap;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;

final class TwintSoapClassMap
{
    public static function getCollection(): ClassMapCollection
    {
        return new ClassMapCollection(
            new ClassMap('CurrencyAmountType', Type\CurrencyAmountType::class),
            new ClassMap('MerchantInformationBaseType', Type\MerchantInformationBaseType::class),
            new ClassMap('MerchantInformationType', Type\MerchantInformationType::class),
            new ClassMap('CheckSystemStatusRequestType', Type\CheckSystemStatusRequestType::class),
            new ClassMap('CheckSystemStatusResponseType', Type\CheckSystemStatusResponseType::class),
            new ClassMap('TWINTTokenType', Type\TWINTTokenType::class),
            new ClassMap('RegistrationRequestType', Type\RegistrationRequestType::class),
            new ClassMap('RequestCheckInRequestType', Type\RequestCheckInRequestType::class),
            new ClassMap('RequestCheckInResponseType', Type\RequestCheckInResponseType::class),
            new ClassMap('MonitorCheckInRequestType', Type\MonitorCheckInRequestType::class),
            new ClassMap('MonitorCheckInResponseType', Type\MonitorCheckInResponseType::class),
            new ClassMap('CancelCheckInRequestType', Type\CancelCheckInRequestType::class),
            new ClassMap('CancelCheckInResponseType', Type\CancelCheckInResponseType::class),
            new ClassMap('StartOrderRequestType', Type\StartOrderRequestType::class),
            new ClassMap('StartOrderResponseType', Type\StartOrderResponseType::class),
            new ClassMap('MonitorOrderRequestType', Type\MonitorOrderRequestType::class),
            new ClassMap('MonitorOrderResponseType', Type\MonitorOrderResponseType::class),
            new ClassMap('IsUofConnectionActiveRequestType', Type\IsUofConnectionActiveRequestType::class),
            new ClassMap('IsUofConnectionActiveResponseType', Type\IsUofConnectionActiveResponseType::class),
            new ClassMap('ConfirmOrderRequestType', Type\ConfirmOrderRequestType::class),
            new ClassMap('ConfirmOrderResponseType', Type\ConfirmOrderResponseType::class),
            new ClassMap('CancelOrderRequestType', Type\CancelOrderRequestType::class),
            new ClassMap('CancelOrderResponseType', Type\CancelOrderResponseType::class),
            new ClassMap('FindOrderRequestType', Type\FindOrderRequestType::class),
            new ClassMap('FindOrderResponseType', Type\FindOrderResponseType::class),
            new ClassMap('EnrollCashRegisterRequestType', Type\EnrollCashRegisterRequestType::class),
            new ClassMap('EnrollCashRegisterResponseType', Type\EnrollCashRegisterResponseType::class),
            new ClassMap('CheckSystemStatusRequestType', Type\CheckSystemStatusRequestType::class),
            new ClassMap('CheckSystemStatusResponseType', Type\CheckSystemStatusResponseType::class),
            new ClassMap(
                'StartOrderAndUofRegistrationRequestType',
                Type\StartOrderAndUofRegistrationRequestType::class
            ),
            new ClassMap(
                'StartOrderAndUofRegistrationResponseType',
                Type\StartOrderAndUofRegistrationResponseType::class
            ),
            new ClassMap(
                'MonitorOrderAndUofRegistrationRequestType',
                Type\MonitorOrderAndUofRegistrationRequestType::class
            ),
            new ClassMap(
                'MonitorOrderAndUofRegistrationResponseType',
                Type\MonitorOrderAndUofRegistrationResponseType::class
            ),
            new ClassMap(
                'ConfirmOrderAndUofRegistrationRequestType',
                Type\ConfirmOrderAndUofRegistrationRequestType::class
            ),
            new ClassMap(
                'ConfirmOrderAndUofRegistrationResponseType',
                Type\ConfirmOrderAndUofRegistrationResponseType::class
            ),
            new ClassMap(
                'CancelOrderAndUofRegistrationRequestType',
                Type\CancelOrderAndUofRegistrationRequestType::class
            ),
            new ClassMap(
                'CancelOrderAndUofRegistrationResponseType',
                Type\CancelOrderAndUofRegistrationResponseType::class
            ),
            new ClassMap('KeyValueType', Type\KeyValueType::class),
            new ClassMap('CustomerInformationType', Type\CustomerInformationType::class),
            new ClassMap('LoyaltyType', Type\LoyaltyType::class),
            new ClassMap('CouponListType', Type\CouponListType::class),
            new ClassMap('CouponType', Type\CouponType::class),
            new ClassMap('RejectedCouponType', Type\RejectedCouponType::class),
            new ClassMap('CouponRejectionReason', Type\CouponRejectionReason::class),
            new ClassMap('CheckInNotificationType', Type\CheckInNotificationType::class),
            new ClassMap('OrderStatusType', Type\OrderStatusType::class),
            new ClassMap('CodeValueType', Type\CodeValueType::class),
            new ClassMap('OrderRequestType', Type\OrderRequestType::class),
            new ClassMap('TimeBasedDataType', Type\TimeBasedDataType::class),
            new ClassMap('OrderType', Type\OrderType::class),
            new ClassMap('BNPLDataType', Type\BNPLDataType::class),
            new ClassMap('PaymentAmountType', Type\PaymentAmountType::class),
            new ClassMap('OrderLinkType', Type\OrderLinkType::class),
            new ClassMap('BeaconSecurityType', Type\BeaconSecurityType::class),
            new ClassMap('GetCertificateValidityRequestType', Type\GetCertificateValidityRequestType::class),
            new ClassMap('GetCertificateValidityResponseType', Type\GetCertificateValidityResponseType::class),
            new ClassMap('RenewCertificateRequestType', Type\RenewCertificateRequestType::class),
            new ClassMap('RenewCertificateResponseType', Type\RenewCertificateResponseType::class),
            new ClassMap('ExpressMerchantAuthorizationType', Type\ExpressMerchantAuthorizationType::class),
            new ClassMap('GetOrderRequestType', Type\GetOrderRequestType::class),
            new ClassMap('GetOrderResponseType', Type\GetOrderResponseType::class),
            new ClassMap('RegistrationType', Type\RegistrationType::class),
            new ClassMap('RequestHeaderType', Type\RequestHeaderType::class),
            new ClassMap('ResponseHeaderType', Type\ResponseHeaderType::class),
            new ClassMap('BaseFault', Type\BaseFault::class),
            new ClassMap('ErrorCode', Type\ErrorCode::class),
        );
    }
}
