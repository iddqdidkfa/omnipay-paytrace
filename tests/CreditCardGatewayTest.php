<?php

namespace Omnipay\Paytrace;

class CreditCardGatewayTest extends \Omnipay\Tests\GatewayTestCase
{
    /** @var  CreditCardGateway */
    protected $gateway;
    protected $options;

    public function setUp()
    {
        $this->gateway = new CreditCardGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPassword('demo123')
            ->setUserName('demo123')
            ->setTestMode(true);
        $this->options = [
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        ];
    }

    public function testAuthorizeSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\AuthorizeResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('104', $response->getCode());
        $this->assertSame(
            'Your TEST transaction was successfully approved. HOWEVER, A LIVE APPROVAL WAS NOT OBTAINED.',
            $response->getMessage()
        );
    }

    public function testAuthorizeFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\AuthorizeResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\AuthorizeResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('104', $response->getCode());
        $this->assertSame(
            'Your TEST transaction was successfully approved. HOWEVER, A LIVE APPROVAL WAS NOT OBTAINED.',
            $response->getMessage()
        );
    }

    public function testPurchaseFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\AuthorizeResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\CaptureResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('108', $response->getCode());
        $this->assertSame(
            'Your TEST transaction was successfully refunded. HOWEVER, NO FUNDS WILL BE REFUNDED.',
            $response->getMessage()
        );
    }

    public function testRefundFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\CaptureResponse', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }
}
