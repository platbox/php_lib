<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when code is not integer
 */
class CodeIsNotIntegerException extends Exception
{
    /**
     * CodeIsNotIntegerException constructor.
     *
     * @param int       $code           Code of exception
     * @param Exception $previous       Previous exception
     */
    public function __construct($code = CallbackErrorCodesEnum::GENERAL_TECHNICAL_ERROR, Exception $previous = null)
    {
        parent::__construct('The code is not a integer', $code, $previous);
    }
}
