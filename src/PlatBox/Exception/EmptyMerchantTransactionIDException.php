<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when merchant transaction is empty
 */
class EmptyMerchantTransactionIDException extends Exception
{
    /**
     * EmptyMerchantTransactionIDException constructor.
     *
     * @param int       $code           Code of exception
     * @param Exception $previous       Previous exception
     */
    public function __construct($code = CallbackErrorCodesEnum::GENERAL_TECHNICAL_ERROR, Exception $previous = null)
    {
        parent::__construct('Empty merchant transaction ID', $code, $previous);
    }
}
