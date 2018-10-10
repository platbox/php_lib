<?php
namespace PlatBox\Callback;

use PlatBox\Enum\CallbackResponseStatusEnum;
use PlatBox\Exception\CodeIsNotIntegerException;
use PlatBox\Exception\EmptyMerchantTransactionIDException;


/**
 * Class CheckCallback
 *
 * @package PlatBox\Callback
 */
class CheckCallback extends Callback
{
    /**
     * Generate success response for check request
     *
     * @param string $merchantTxId    Merchant transaction ID
     * @param array  $merchantTxExtra Merchant transaction extra info
     *
     * @return string
     * @throws EmptyMerchantTransactionIDException
     */
    public function generateSuccessResponse($merchantTxId, array $merchantTxExtra = array())
    {
        if (empty(trim((string) $merchantTxId))) {
            throw new EmptyMerchantTransactionIDException();
        }

        $response                      = array();
        $response['status']            = CallbackResponseStatusEnum::OK;
        $response['merchant_tx_id']    = (string) $merchantTxId;
        $response['merchant_tx_extra'] = $merchantTxExtra;

        $response = json_encode($response);

        return $response;
    }

    /**
     * @param integer $code        Error code
     * @param string  $description Error description
     *
     * @return string
     * @throws CodeIsNotIntegerException
     */
    public function generateErrorResponse($code, $description)
    {
        if (empty((integer) $code)) {
            throw new CodeIsNotIntegerException();
        }

        $response                = array();
        $response['status']      = CallbackResponseStatusEnum::ERROR;
        $response['code']        = (integer) $code;
        $response['description'] = (string) $description;

        $response = json_encode($response);

        return $response;
    }
}