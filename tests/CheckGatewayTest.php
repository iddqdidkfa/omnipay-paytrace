<?php

namespace Omnipay\Paytrace;

class CheckGatewayTest extends \Omnipay\Tests\GatewayTestCase
{
    /** @var  CreditCardGateway */
    protected $gateway;
    protected $options;

    public function setUp()
    {
        $this->gateway = new CheckGateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->setPassword('demo123')
            ->setUserName('demo123')
            ->setTestMode(true);
        $this->options = [
            'amount' => '10.00',
            'check' => [
                'routingNumber' => '325070760',
                'bankAccount' => '1234567890',
                'name' => 'John DOe',
            ],
        ];
    }

    public function testAuthorizeSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('121', $response->getCode());
        $this->assertSame(
            'Your TEST check was successfully processed. HOWEVER, FUNDS WILL NOT BE TRANSFERRED.',
            $response->getMessage()
        );
    }

    public function testAuthorizeFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('121', $response->getCode());
        $this->assertSame(
            'Your TEST check was successfully processed. HOWEVER, FUNDS WILL NOT BE TRANSFERRED.',
            $response->getMessage()
        );
    }

    public function testPurchaseFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->gateway->setPassword('demo123');
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNotEmpty($response->getTransactionReference());
        $this->assertSame('123', $response->getCode());
        $this->assertSame(
            'Your TEST check was successfully refunded. HOWEVER, NO FUNDS WILL BE TRANSFERRED.',
            $response->getMessage()
        );
    }

    public function testRefundFailure()
    {
        $this->gateway->setPassword('111');
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }
}
