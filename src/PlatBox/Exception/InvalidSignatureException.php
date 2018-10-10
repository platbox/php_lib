<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when signature is invalid
 */
class InvalidSignatureException extends Exception
{
    /**
     * Expected sign
     *
     * @var string
     */
    private $expectedSign;

    /**
     * Incoming sign
     *
     * @var string
     */
    private $incomingSign;

    /**
     * InvalidSignatureException constructor.
     *
     * @param string    $expectedSign expected sign
     * @param string    $incomingSign incoming sign
     * @param int       $code         code of exception
     * @param Exception $previous     previous exception
     */
    public function __construct($expectedSign, $incomingSign, $code = CallbackErrorCodesEnum::INVALID_REQUEST_SIGNATURE, Exception $previous = null)
    {
        parent::__construct('Invalid signature provided', $code, $previous);

        $this->expectedSign = $expectedSign;
        $this->incomingSign = $incomingSign;
    }

    /**
     * Get expected sign
     *
     * @return string
     */
    public function getExpectedSign()
    {
        return $this->expectedSign;
    }

    /**
     * Get incoming sign
     *
     * @return string
     */
    public function getIncomingSign()
    {
        return $this->incomingSign;
    }


}
