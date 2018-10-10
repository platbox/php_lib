<?php
namespace PlatBox\Libraries;

use PlatBox\Exception\InvalidSignatureException;


/**
 * Class for generating standard signature
 */
class SignatureHelper implements SignatureHelperInterface
{
    /**
     * Default hash algorithm
     */
    const DEFAULT_HASH_ALGORITHM = 'sha256';

    /**
     * Generate sign using default algorithm (HMAC)
     *
     * @param string $requestToSign message body to sign
     * @param string $secretKey     secret key for sign
     * @param string $hashAlgorithm
     *
     * @return string
     */
    public function generateSign($requestToSign, $secretKey, $hashAlgorithm = self::DEFAULT_HASH_ALGORITHM)
    {
        $sign = hash_hmac($hashAlgorithm, $requestToSign, $secretKey);

        return $sign;
    }

    /**
     * @param string $sign          sign to compare
     * @param string $requestToSign body to sign
     * @param string $secretKey     secret key
     * @param string $hashAlgorithm
     *
     * @throws InvalidSignatureException
     */
    public function checkSign($sign, $requestToSign, $secretKey, $hashAlgorithm = self::DEFAULT_HASH_ALGORITHM)
    {
        $expectedSign = $this->generateSign($requestToSign, $secretKey, $hashAlgorithm);
        if ((string) $sign !== $expectedSign) {
            throw new InvalidSignatureException($expectedSign, $sign);
        }
    }

}
