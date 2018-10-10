<?php
namespace PlatBox\Callback;


use PlatBox\Exception\EmptyIncomingSignatureException;
use PlatBox\Exception\InvalidSignatureException;
use PlatBox\Libraries\SignatureHelper;
use PlatBox\Libraries\SignatureHelperInterface;

/**
 * Class Callback
 *
 * @package PlatBox\Callback
 */
abstract class Callback
{
    /**
     * Key name of the $ _SERVER array that stores the signature
     */
    const SIGN_HEADER = 'HTTP_X_SIGNATURE';

    /**
     * Incoming post raw data
     *
     * @var string
     */
    private $rawData;

    /**
     * Secret key
     *
     * @var string
     */
    private $secretKey;

    /**
     * @var SignatureHelperInterface
     */
    private $signatureHelper;

    /**
     * Callback constructor.
     *
     * @param string                   $rawData
     * @param string                   $secretKey
     * @param string|null              $incomingSignature
     * @param SignatureHelperInterface $signatureHelper
     *
     * @throws EmptyIncomingSignatureException
     * @throws InvalidSignatureException
     */
    public function __construct(
        $rawData, $secretKey, $incomingSignature = null, SignatureHelperInterface $signatureHelper = null
    ) {
        $this->rawData         = $rawData;
        $this->secretKey       = $secretKey;
        $this->signatureHelper = !is_null($signatureHelper) ? $signatureHelper : new SignatureHelper();
        $this->checkSignature($incomingSignature);
    }

    /**
     * Check signature
     *
     * @param string $incomingSignature
     *
     * @throws EmptyIncomingSignatureException
     * @throws InvalidSignatureException
     */
    public function checkSignature($incomingSignature = "")
    {
        if (empty($incomingSignature) and !empty($_SERVER[self::SIGN_HEADER])) {
            $incomingSignature = $_SERVER[self::SIGN_HEADER];
        }

        if (empty($incomingSignature)) {
            throw new EmptyIncomingSignatureException();
        }

        $this->signatureHelper->checkSign($incomingSignature, $this->rawData, $this->secretKey);
    }

    /**
     * Generate signature for last request
     *
     * @param string $response Response for generate signature
     *
     * @return string
     */
    public function generateSignature($response)
    {
        $signature = $this->signatureHelper->generateSign($response, $this->secretKey);

        return $signature;
    }

    /**
     * Return array incoming params
     *
     * @return array
     */
    public function getParams()
    {
        $params = json_decode($this->rawData, true);

        return $params;
    }
}