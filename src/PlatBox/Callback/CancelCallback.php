<?php
namespace PlatBox\Callback;

use PlatBox\Enum\CallbackResponseStatusEnum;
use PlatBox\Exception\EmptyMerchantTransactionTimestampException;


/**
 * Class CancelCallback
 *
 * @package PlatBox\Callback
 */
class CancelCallback extends Callback
{
    /**
     * Generate success response for cancel request
     *
     * @param string $merchantTxTimestamp Merchant transaction timestamp. Format 'DATE_RFC3339'. Example: "2014-10-12T04:13:45+04:00".
     * @param array  $merchantTxExtra     Merchant transaction extra info
     *
     * @return string
     * @throws EmptyMerchantTransactionTimestampException
     */
    public function generateSuccessResponse($merchantTxTimestamp, array $merchantTxExtra = array())
    {
        if (empty(trim((string) $merchantTxTimestamp))) {
            throw new EmptyMerchantTransactionTimestampException();
        }

        $response                          = array();
        $response['status']                = CallbackResponseStatusEnum::OK;
        $response['merchant_tx_timestamp'] = (string) $merchantTxTimestamp;
        $response['merchant_tx_extra']     = $merchantTxExtra;

        $response = json_encode($response);

        return $response;
    }
}