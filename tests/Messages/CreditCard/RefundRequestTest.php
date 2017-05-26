<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /** @var  \Omnipay\Paytrace\Message\CreditCard\RefundRequest $request */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new RefundRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $expectedData = [
            'username' => 'tester',
            'password' => 'testpwd',
            'invoiceId' => '1000001',
            'amount' => '10.00',
            'card' => [
                'firstName' => 'Example',
                'lastName' => 'User',
                'number' => '4111111111111111',
                'expiryMonth' => '07',
                'expiryYear' => '2020',
                'cvv' => '123',
            ],
            'testmode' => 1,
        ];

        $this->request->initialize($expectedData);

        $data = $this->request->getData();

        $this->assertSame('4111111111111111', $data['CC']);
        $this->assertSame(substr($expectedData['card']['expiryYear'], -2), $data['EXPYR']);
        $this->assertSame($expectedData['card']['expiryMonth'], $data['EXPMNTH']);
        $this->assertSame($expectedData['username'], $data['UN']);
        $this->assertSame($expectedData['password'], $data['PSWD']);
        $this->assertSame('ProcessTranx', $data['METHOD']);
        $this->assertSame('Refund', $data['TRANXTYPE']);
        $this->assertSame('10.00', $data['AMOUNT']);
        $this->assertSame('Y', $data['TERMS']);
    }
}
