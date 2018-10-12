PlatBox - Libraries that implement connection to the PlatBox payment system
========================================

Libraries that implement connection to the PlatBox payment system.

See [https://platbox.com/](https://platbox.com/) and [https://api.platbox.com/](https://api.platbox.com/) for more information and documentation.


Installation
--------------------
Use composer to manage your dependencies and download these libraries

```bash
composer require platbox/php_lib
```


Example - Generate link to PayBox
--------------------

```php
<?php
require __DIR__.'/vendor/autoload.php';

use PlatBox\PayBox\PayBox;
use PlatBox\Exception\NoRequiredParamException;

$paramsForTransaction = [
    'account_id'  => 'support-merchant@platbox.com',
    'amount'      => 1000,
    'currency'    => 'RUB',
    'merchant_id' => 'INSERT YOUR OPEN KEY',
    'order'       => 'Order_1',
    'order_label' => 'Order description on payment page',
    'project'     => 'INSERT YOUR PROJECT',
];

$secretKey = 'INSERT YOUR SECRET KEY';

$paybox = new PayBox($paramsForTransaction, $secretKey, 'https://payment-playground.platbox.com/pay');

try {
    $link = $paybox->generateLinkToPayBox();

    echo $link;
} catch (NoRequiredParamException $exception) {
    echo "ERROR: ".$exception->getMessage();
    print_r($exception->getParamsNotExist());
}
```

Example - Query processing callback
--------------------
```php
<?php
use PlatBox\Callback\CancelCallback;
use PlatBox\Callback\CheckCallback;
use PlatBox\Callback\PayCallback;

require __DIR__.'/vendor/autoload.php';

$rawData   = file_get_contents("php://input");
$secretKey = 'INSERT YOUR SECRET KEY';

try {
    $params   = json_decode($rawData, true);
    switch ($params['action']) {
        case 'check':
            $callback = new CheckCallback($rawData, $secretKey);
            /**
             * Validate payment information. See https://api.platbox.com/
             * 
             * In case of failure validation (input payment order was not found or user account not valid)
             * you should return response with error code and description. 
             * (Use $response = $callback->generateErrorResponse(1001, 'Account is not found');
             */
            $response = $callback->generateSuccessResponse('TransactionID1');
            break;
        case 'pay':
            $callback = new PayCallback($rawData, $secretKey);
            /**
             * Validate payment information. See https://api.platbox.com/
             * Fixing pay success status
             */
            $response = $callback->generateSuccessResponse("2014-10-12T04:13:45+04:00");
            break;
        case 'cancel':
            $callback = new CancelCallback($rawData, $secretKey);
            /**
             * Fixing pay failed status
             */
            $response = $callback->generateSuccessResponse("2014-10-12T04:13:45+04:00");
            break;
    }
    header('X-Signature: '.$callback->generateSignature($response));
    echo $response;
} catch (Exception $exception) {
    echo $exception->getMessage();
}
```