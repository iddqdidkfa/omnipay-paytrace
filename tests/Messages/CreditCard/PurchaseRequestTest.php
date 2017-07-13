<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /** @var  \Omnipay\Paytrace\Message\CreditCard\PurchaseRequest $request */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
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
                'expiryYear' => '2050',
                'cvv' => '123',
                'billingAddress1' => '123 Billing St',
                'billingAddress2' => 'Billsville',
                'billingCity' => 'Billstown',
                'billingPostcode' => '12345',
                'billingState' => 'CA',
                'billingCountry' => 'US',
                'billingPhone' => '(555) 123-4567',
                'shippingAddress1' => '123 Shipping St',
                'shippingAddress2' => 'Shipsville',
                'shippingCity' => 'Shipstown',
                'shippingPostcode' => '54321',
                'shippingState' => 'NY',
                'shippingCountry' => 'US',
                'shippingPhone' => '(555) 987-6543',
            ],
            'testmode' => 1,
        ];

        $this->request->initialize($expectedData);

        $data = $this->request->getData();

        $this->assertSame('4111111111111111', $data['CC']);
        $this->assertSame('Example User', $data['BNAME']);
        $this->assertSame(substr($expectedData['card']['expiryYear'], -2), $data['EXPYR']);
        $this->assertSame($expectedData['card']['expiryMonth'], $data['EXPMNTH']);
        $this->assertSame($expectedData['card']['billingCity'], $data['BCITY']);
        $this->assertSame($expectedData['card']['shippingCity'], $data['SCITY']);
        $this->assertSame($expectedData['username'], $data['UN']);
        $this->assertSame($expectedData['password'], $data['PSWD']);
        $this->assertSame('ProcessTranx', $data['METHOD']);
        $this->assertSame('Sale', $data['TRANXTYPE']);
        $this->assertSame('10.00', $data['AMOUNT']);
        $this->assertSame('Y', $data['TERMS']);
    }
}
