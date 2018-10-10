<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when action is unknown
 */
class UnknownActionException extends Exception
{
    /**
     * UnknownActionException constructor.
     *
     * @param int       $code           Code of exception
     * @param Exception $previous       Previous exception
     */
    public function __construct($code = CallbackErrorCodesEnum::GENERAL_TECHNICAL_ERROR, Exception $previous = null)
    {
        parent::__construct('Unknown action', $code, $previous);
    }
}
