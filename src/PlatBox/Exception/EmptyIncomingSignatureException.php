<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when incoming signature is empty
 */
class EmptyIncomingSignatureException extends Exception
{
    /**
     * EmptyIncomingSignatureException constructor.
     *
     * @param int       $code           Code of exception
     * @param Exception $previous       Previous exception
     */
    public function __construct($code = CallbackErrorCodesEnum::GENERAL_TECHNICAL_ERROR, Exception $previous = null)
    {
        parent::__construct('Incoming signature is empty', $code, $previous);
    }
}
