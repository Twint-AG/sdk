<?php

declare(strict_types=1);

namespace Twint\Sdk\Generated;

use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMap;
use Soap\ExtSoapEngine\Configuration\ClassMap\ClassMapCollection;

class TwintSoapClassMap
{
    public static function getCollection(): ClassMapCollection
    {
        return new ClassMapCollection(
            new ClassMap('OrderRequestType', Type\OrderRequestType::class),
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
            new ClassMap('CheckSystemStatusRequestElement', Type\CheckSystemStatusRequestElement::class),
            new ClassMap('CurrencyAmountType', Type\CurrencyAmountType::class),
            new ClassMap('MerchantInformationBaseType', Type\MerchantInformationBaseType::class),
            new ClassMap('MerchantInformationType', Type\MerchantInformationType::class),
            new ClassMap('TWINTTokenType', Type\TWINTTokenType::class),
            new ClassMap('RegistrationRequestType', Type\RegistrationRequestType::class),
            new ClassMap('RequestHeaderType', Type\RequestHeaderType::class),
            new ClassMap('ResponseHeaderType', Type\ResponseHeaderType::class),
            new ClassMap('BaseFault', Type\BaseFault::class),
            new ClassMap('ErrorCode', Type\ErrorCode::class),
            new ClassMap('SystemError', Type\SystemError::class),
            new ClassMap('InvalidParameter', Type\InvalidParameter::class),
            new ClassMap('InvalidMerchant', Type\InvalidMerchant::class),
            new ClassMap('InvalidCashRegister', Type\InvalidCashRegister::class),
            new ClassMap('InvalidAmount', Type\InvalidAmount::class),
            new ClassMap('InvalidCurrency', Type\InvalidCurrency::class),
            new ClassMap('InvalidOfflineAuthorization', Type\InvalidOfflineAuthorization::class),
            new ClassMap('InvalidOrder', Type\InvalidOrder::class),
            new ClassMap('InvalidCustomerRelationKey', Type\InvalidCustomerRelationKey::class),
            new ClassMap('InvalidVoucherCategory', Type\InvalidVoucherCategory::class),
            new ClassMap('InvalidVoucher', Type\InvalidVoucher::class),
            new ClassMap('InvalidMerchantTransactionReference', Type\InvalidMerchantTransactionReference::class),
            new ClassMap('StatusTransitionError', Type\StatusTransitionError::class),
            new ClassMap('ActiveOrderError', Type\ActiveOrderError::class),
            new ClassMap('AuthorizationError', Type\AuthorizationError::class),
            new ClassMap('TimeoutError', Type\TimeoutError::class),
            new ClassMap('ReversalError', Type\ReversalError::class),
            new ClassMap('ActivePairingError', Type\ActivePairingError::class),
            new ClassMap('UnspecifiedPairingError', Type\UnspecifiedPairingError::class),
            new ClassMap('AccountLockedError', Type\AccountLockedError::class),
            new ClassMap('PairingError', Type\PairingError::class),
            new ClassMap('FundsError', Type\FundsError::class),
            new ClassMap('CashregisterAccessError', Type\CashregisterAccessError::class),
            new ClassMap('BusinessError', Type\BusinessError::class),
            new ClassMap('CertificateRenewalRefused', Type\CertificateRenewalRefused::class),
            new ClassMap('CertificateRenewalNotAllowed', Type\CertificateRenewalNotAllowed::class),
            new ClassMap('InvalidToken', Type\InvalidToken::class),
            new ClassMap('DurationTooLong', Type\DurationTooLong::class),
            new ClassMap('ExpressConnectionCanceled', Type\ExpressConnectionCanceled::class),
            new ClassMap('ExpressCheckoutCredentialsInvalid', Type\ExpressCheckoutCredentialsInvalid::class),
            new ClassMap('UofNotAllowed', Type\UofNotAllowed::class),
            new ClassMap('InvalidOperationForCombinedOrder', Type\InvalidOperationForCombinedOrder::class),
            new ClassMap('InvalidCombinedOrder', Type\InvalidCombinedOrder::class),
            new ClassMap('InvalidPreAuthOrder', Type\InvalidPreAuthOrder::class),
        );
    }
}
