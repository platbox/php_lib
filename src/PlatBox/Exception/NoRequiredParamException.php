<?php
namespace PlatBox\Exception;

use Exception;
use PlatBox\Enum\CallbackErrorCodesEnum;

/**
 * Exception occurs when required params don't exist
 */
class NoRequiredParamException extends Exception
{
    /**
     * Array with missing parameters
     *
     * @var array
     */
    private $paramsNotExist;

    /**
     * NoRequiredParamException constructor.
     *
     * @param array     $paramsNotExist Array contain non existing parameters
     * @param int       $code           Code of exception
     * @param Exception $previous       Previous exception
     */
    public function __construct(array $paramsNotExist, $code = CallbackErrorCodesEnum::INVALID_REQUEST_DATA, Exception $previous = null)
    {
        parent::__construct('Required params not exist', $code, $previous);
        $this->paramsNotExist = $paramsNotExist;
    }

    /**
     * Get array with missing parameters
     *
     * @return array
     */
    public function getParamsNotExist()
    {
        return $this->paramsNotExist;
    }
}
