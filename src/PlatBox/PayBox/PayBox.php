<?php
namespace PlatBox\PayBox;

use PlatBox\Exception\NoRequiredParamException;
use PlatBox\Libraries\SignatureHelper;
use PlatBox\Libraries\SignatureHelperInterface;

/**
 * Class PayBox
 *
 * @package PlatBox\PayBox
 */
class PayBox
{
    /**
     * Default sorted params for concatenating the signature line
     */
    const SORTED_MERCHANT_PARAMS = [
        'account_additional',
        'account_id',
        'account_location',
        'additional',
        'amount',
        'currency',
        'merchant_id',
        'order_id',
        'project',
        'receipt_data',
        'redirect_url',
    ];

    /**
     * Default required params for concatenating the signature line
     */
    const REQUIRED_MERCHANT_PARAMS = [
        'account_id',
        'merchant_id',
        'project',
    ];

    /**
     * Default paybox url
     */
    const DEFAULT_PAYBOX_URL = 'https://payment.platbox.com/pay';

    /**
     * Params for generate signature/link
     *
     * @var array
     */
    private $params;

    /**
     * PayBox url
     *
     * @var string
     */
    private $url;

    /**
     * Service to work with the signature
     *
     * @var SignatureHelperInterface
     */
    private $signatureHelper;

    /**
     * The secret key
     *
     * @var string
     */
    private $secretKey;

    /**
     * PayBox helper constructor.
     *
     * @param array                    $params
     * @param string                   $secretKey
     * @param string                   $url
     * @param SignatureHelperInterface $signatureHelper
     */
    public function __construct(
        array $params,
        $secretKey,
        $url = self::DEFAULT_PAYBOX_URL,
        SignatureHelperInterface $signatureHelper = null
    ) {
        $this->params          = $params;
        $this->secretKey       = $secretKey;
        $this->url             = $url;
        $this->signatureHelper = !is_null($signatureHelper) ? $signatureHelper : new SignatureHelper();
    }

    /**
     * Update Parameters
     *
     * @param array $params
     */
    public function updateParams(array $params = array())
    {
        $this->params = array_merge($this->params, $params);
    }

    /**
     * Secret key entry
     *
     * @param string $secretKey
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * Url entry
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Generate link to PayBox
     *
     * @throws NoRequiredParamException
     */
    public function generateLinkToPayBox()
    {
        $linkParams = $this->params;

        $signature  = $this->generateSignatureToPayBox();
        $linkParams = array_merge($linkParams, ['sign' => $signature]);

        $url = $this->url."?".http_build_query($linkParams);

        return $url;
    }

    /**
     * Generate signature for PayBox
     *
     * @throws NoRequiredParamException
     */
    public function generateSignatureToPayBox()
    {
        $this->checkRequiredParams();
        $string    = $this->generateStringForSign();
        $signature = $this->signatureHelper->generateSign($string, $this->secretKey);

        return $signature;
    }

    /**
     * Check required input params
     *
     * @throws NoRequiredParamException
     */
    private function checkRequiredParams()
    {
        $notExistRequiredParams = array();
        foreach (self::REQUIRED_MERCHANT_PARAMS as $paramName) {
            if (!isset($this->params[$paramName])) {
                $notExistRequiredParams[] = $paramName;
            }
        }
        if (count($notExistRequiredParams) > 0) {
            throw new NoRequiredParamException($notExistRequiredParams);
        }
    }

    /**
     * Generate string by incoming params
     *
     * @return string
     */
    private function generateStringForSign()
    {
        $string = '';
        foreach (self::SORTED_MERCHANT_PARAMS as $paramName) {
            if (isset($this->params[$paramName])) {
                $string .= $this->params[$paramName];
            }
        }

        return $string;
    }
}