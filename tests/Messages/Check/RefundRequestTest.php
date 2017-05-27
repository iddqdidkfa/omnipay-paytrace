<?php

namespace Omnipay\Paytrace\Message\Check;

use Omnipay\Tests\TestCase;

class RefundRequestTest extends TestCase
{
    /** @var  \Omnipay\Paytrace\Message\Check\RefundRequest $request */
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
            'currency' => 'EUR',
            'invoiceId' => '1000001',
            'amount' => '10.00',
            'check' => [
                'bankAccount' => '1234567890',
                'routingNumber' => '325070760',
                'name' => 'John Doe',
            ],
            'testmode' => 1,
        ];

        $this->request->initialize($expectedData);

        $data = $this->request->getData();

        $this->assertSame($expectedData['check']['name'], $data['BNAME']);
        $this->assertSame($expectedData['check']['bankAccount'], $data['DDA']);
        $this->assertSame($expectedData['check']['routingNumber'], $data['TR']);
        $this->assertSame($expectedData['username'], $data['UN']);
        $this->assertSame($expectedData['password'], $data['PSWD']);
        $this->assertSame('ProcessCheck', $data['METHOD']);
        $this->assertSame('Refund', $data['CHECKTYPE']);
        $this->assertSame('10.00', $data['AMOUNT']);
        $this->assertSame('Y', $data['TERMS']);
    }
}
