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
        $this->setMockHttpResponse('Check/ResponseSuccess.txt');

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
        $this->setMockHttpResponse('Check/ResponseFailed.txt');

        $this->gateway->setPassword('111');
        $response = $this->gateway->authorize($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testPurchaseSuccess()
    {
        $this->setMockHttpResponse('Check/ResponseSuccess.txt');

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
        $this->setMockHttpResponse('Check/ResponseFailed.txt');

        $this->gateway->setPassword('111');
        $response = $this->gateway->purchase($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testRefundSuccess()
    {
        $this->setMockHttpResponse('Check/RefundResponseSuccess.txt');

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

    public function testRefundTransactionReferenceSuccess()
    {
        $this->setMockHttpResponse('Check/RefundResponseSuccess.txt');

        $this->gateway->setPassword('demo123');
        $options = array_merge(array('transactionReference' => 89731989), $this->options);
        unset($options['check']);
        $response = $this->gateway->refund($options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertSame('89731989', $response->getTransactionReference());
        $this->assertSame('123', $response->getCode());
        $this->assertSame(
            'Your TEST check was successfully refunded. HOWEVER, NO FUNDS WILL BE TRANSFERRED.',
            $response->getMessage()
        );
    }

    public function testRefundFailure()
    {
        $this->setMockHttpResponse('Check/ResponseFailed.txt');

        $this->gateway->setPassword('111');
        $response = $this->gateway->refund($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\Check\Response', $response);
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }

    public function testCreateCardSuccess()
    {
        $this->setMockHttpResponse('Check/CreateCardResponseSuccess.txt');

        $this->gateway->setPassword('demo123');
        $response = $this->gateway->createCard($this->options)->send();
        $this->assertInstanceOf('\Omnipay\Paytrace\Message\CreditCard\CreateCardResponse', $response);
        $this->assertTrue($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
        $this->assertNull($response->getTransactionReference());
        $this->assertSame('160', $response->getCode());
        $this->assertSame('14496097', $response->getCardReference());
        $this->assertSame(
            'The customer profile for 14496097\/John Doe was successfully created.',
            $response->getMessage()
        );
    }
}
