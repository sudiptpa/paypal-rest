# Omnipay: PayPal REST API

**PayPal REST API driver for the Omnipay PHP payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP. This package implements Openpay support for Omnipay.

[![StyleCI](https://github.styleci.io/repos/173117409/shield?branch=master&style=flat)](https://github.styleci.io/repos/173117409)
[![Latest Stable Version](https://poser.pugx.org/sudiptpa/omnipay-openpay/v/stable)](https://packagist.org/packages/sudiptpa/omnipay-openpay)
[![Total Downloads](https://poser.pugx.org/sudiptpa/omnipay-openpay/downloads)](https://packagist.org/packages/sudiptpa/omnipay-openpay)
[![License](https://poser.pugx.org/sudiptpa/omnipay-openpay/license)](https://packagist.org/packages/sudiptpa/omnipay-openpay)

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

 Orders v2 API

 * [Create Order](https://developer.paypal.com/docs/api/orders/v2/#orders_create)
 * [Show Order Details](https://developer.paypal.com/docs/api/orders/v2/#orders_get)
 * [Capture Payment for Order](https://developer.paypal.com/docs/api/orders/v2/#orders_capture)
 * [Add Tracking for an Order](https://developer.paypal.com/docs/api/orders/v2/#orders_track_create)
 * [Verify Webhook Signature](https://developer.paypal.com/docs/api/webhooks/v1/#verify-webhook-signature_post)
 * [List Webhooks](https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_list)
 * [Delete Webhook](https://developer.paypal.com/docs/api/webhooks/v1/#webhooks_delete)

If you have requirements to follow other features available in PayPal REST API, feel free to submit a PR following the coding standard, contributions are always welcome.

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
