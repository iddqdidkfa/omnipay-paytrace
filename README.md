# Omnipay: PayTrace

**PayTrace driver for the Omnipay PHP payment processing library**

[![Build Status](https://travis-ci.org/iddqdidkfa/omnipay-paytrace.png?branch=master)](https://travis-ci.org/iddqdidkfa/omnipay-paytrace)
[![Latest Stable Version](https://poser.pugx.org/softcommerce/omnipay-paytrace/version.png)](https://packagist.org/packages/softcommerce/omnipay-paytrace)
[![Total Downloads](https://poser.pugx.org/softcommerce/omnipay-paytrace/d/total.png)](https://packagist.org/packages/softcommerce/omnipay-paytrace)

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements [PayTrace](https://www.paytrace.net) support for Omnipay.

This package require PHP 5.4+

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "softcommerce/omnipay-paytrace": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage

The following gateways are provided by this package:

* Paytrace_CreditCard
* Paytrace_Check

Usage Example:
```php
$ccGateway = \Omnipay\Omnipay::create('Paytrace_CreditCard');
$ccGateway->setUserName('demo123')
	->setPassword('demo123')
	->setTestMode(true);

$creditCardData = ['number' => '4242424242424242', 'expiryMonth' => '6', 'expiryYear' => '2016', 'cvv' => '123'];
$response = $ccGateway->purchase(['amount' => '10.00', 'currency' => 'USD', 'card' => $creditCardData])->send();

if ($response->isSuccessful()) {
	// SUCCESS
    echo $response->getMessage();
} else {
	// FAIL
    echo $response->getMessage();
}

$chGateWay = \Omnipay\Omnipay::create('Paytrace_Check');
$chGateway->setUserName('demo123')
	->setPassword('demo123')
	->setTestMode(true);

$checkData = ['routingNumber' => '325070760', 'bankAccount' => '1234567890', 'name' => 'John Doe'];
$response = $chGateway->purchase(['amount' => '10.00', 'currency' => 'USD', 'check' => $checkData])->send();

if ($response->isSuccessful()) {
	// SUCCESS
    echo $response->getMessage();
} else {
	// FAIL
    echo $response->getMessage();
}
```


For general usage instructions, please see the main [Omnipay](https://github.com/thephpleague/omnipay)
repository.

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release announcements, discuss ideas for the project,
or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/iddqdidkfa/omnipay-paytrace/issues),
or better yet, fork the library and submit a pull request.