<?php
namespace PlatBox\Libraries;

use PlatBox\Exception\InvalidSignatureException;


/**
 * Class for generating standard signature
 */
interface SignatureHelperInterface
{
    /**
     * Generate sign using default algorithm (HMAC)
     *
     * @param string $requestToSign message body to sign
     * @param string $secretKey     secret key for sign
     * @param string $hashAlgorithm
     *
     * @return string
     */
    public function generateSign($requestToSign, $secretKey, $hashAlgorithm);

    /**
     * @param string $sign          sign to compare
     * @param string $requestToSign body to sign
     * @param string $secretKey     secret key
     * @param string $hashAlgorithm
     *
     * @throws InvalidSignatureException
     */
    public function checkSign($sign, $requestToSign, $secretKey, $hashAlgorithm);
}