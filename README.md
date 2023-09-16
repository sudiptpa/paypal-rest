# Omnipay: PayPal REST API

**PayPal REST API driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements PayPal REST API support for Omnipay.

[![Latest Stable Version](http://poser.pugx.org/sudiptpa/paypal-rest/v)](https://packagist.org/packages/sudiptpa/paypal-rest) [![Total Downloads](http://poser.pugx.org/sudiptpa/paypal-rest/downloads)](https://packagist.org/packages/sudiptpa/paypal-rest) [![Latest Unstable Version](http://poser.pugx.org/sudiptpa/paypal-rest/v/unstable)](https://packagist.org/packages/sudiptpa/paypal-rest) [![License](http://poser.pugx.org/sudiptpa/paypal-rest/license)](https://packagist.org/packages/sudiptpa/paypal-rest) [![PHP Version Require](http://poser.pugx.org/sudiptpa/paypal-rest/require/php)](https://packagist.org/packages/sudiptpa/paypal-rest)

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "sudiptpa/paypal-rest": "~3.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Usage

The library follows PayPal REST Orders v2 API, and below are the supported features.

 #### Orders API v2

- [Create Order](https://developer.paypal.com/docs/api/orders/v2/#orders_create)
- [Show Order Details](https://developer.paypal.com/docs/api/orders/v2/#orders_get)
- [Capture Payment for Order](https://developer.paypal.com/docs/api/orders/v2/#orders_capture)
- [Add Tracking for an Order](https://developer.paypal.com/docs/api/orders/v2/#orders_track_create)
- [Verify Webhook Signature](https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post)
- [List Webhooks](https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_list)
- [Delete Webhook](https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_delete)

If you want the features other than mentioned above, then feel free to submit a PR by following the coding standard.

#### Initiate Gateway Request

```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('PayPalRest_Rest');

$gateway->setClientId('xxxxxxxxxxx');
$gateway->setSecret('xxxxxxxxxxx');
$gateway->setTestMode('xxxxxxxxxxx');
```

#### Access Token

```php
$accessToken = $gateway->getToken();
 or
$accessToken = $gateway->createToken()->send();
```

Note, the Access Token is not stored in the gateway at this point.

Management of the Access Token is not (yet) included in this library.
You should implement your own method for saving and reusing the Access Token until expired to avoid hitting PayPal query limits by generating a token for each API call.

You can set a previously retrieved Access Token in the gateway as follows:

```php
$gateway->setToken($accessToken);
```

#### API Calls

```php
$payload = [
    'amount' => 20,
    'transactionId' => '1001',
    'transactionReference' => 'INV-1001',
    'currency' => 'USD',
    'items' => [
        [
            'name' => 'Test Product 1',
            'description' => 'A sample description',
            'quantity' => 1,
            'price' => 20,
            'sku' => 'ITEM-CODE1',
            'category' => 'PHYSICAL_GOODS',
            'reference' => 'ITEM',
        ]
    ],
    'cancelUrl' => 'https://example.com/cancel/url',
    'returnUrl' => 'https://example.com/return/url',
];

$response = $gateway->purchase($payload)->send();

if ($response && $response->isSuccessful()) {
    // handle the success

    if ($response->isRedirect()) {
        $response->redirect();
    }

    // do something else
}

// handle the failure
```

#### Capture

```php
$response = $gateway->completePurchase([
    'transactionReference' => 'PAYPAL-ORDER-ID',
])->send();

if ($response && $response->isSuccessful() && $response->isCaptured()) {
    // handle success
}

// handle failure
```

#### Fetch PayPal Order

```php
$response = $gateway->fetchPurchase([
    'transactionReference' => 'PAYPAL-ORDER-ID',
])->send();

if ($response && $response->isSuccessful()) {
    // handle success
}

// handle failure
```

For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/sudiptpa/paypal-rest/issues),
or better yet, fork the library and submit a pull request.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
