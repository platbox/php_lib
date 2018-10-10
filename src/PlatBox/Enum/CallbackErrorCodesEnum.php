<?php
namespace PlatBox\Enum;

/**
 * Class CallbackErrorCodesEnum
 *
 * @package PlatBox\Enum
 */
class CallbackErrorCodesEnum
{
    /**
     * Invalid message format.
     */
    const INVALID_MESSAGE_FORMAT = 400;

    /**
     * Invalid request signature.
     */
    const INVALID_REQUEST_SIGNATURE = 401;

    /**
     * Invalid request data.
     */
    const INVALID_REQUEST_DATA = 406;

    /**
     * General technical error.
     */
    const GENERAL_TECHNICAL_ERROR = 1000;

    /**
     * User account not found or blocked.
     */
    const USER_ACCOUNT_NOT_FOUND_OR_BLOCKED = 1001;

    /**
     * Invalid payment currency.
     */
    const INVALID_PAYMENT_CURRENCY = 1002;

    /**
     * Invalid payment amount.
     */
    const INVALID_PAYMENT_AMOUNT = 1003;

    /**
     * The requested goods or services are not available / the selected product was not found / incorrect data of the user's order.
     */
    const PRODUCTS_OR_SERVICES_ARE_NOT_AVAILABLE = 1005;

    /**
     * A payment with the specified ID is already reserved.
     */
    const TRANSACTION_IS_REGISTER = 2000;

    /**
     * Payment with the specified ID has already been made.
     */
    const TRANSACTION_IS_PAYED = 2001;

    /**
     * Payment with the specified ID has already been canceled.
     */
    const TRANSACTION_IS_CANCELED = 2002;
}