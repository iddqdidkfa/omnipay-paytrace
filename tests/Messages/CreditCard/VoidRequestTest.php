<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class VoidRequestTest extends TestCase
{
    /** @var  \Omnipay\Paytrace\Message\CreditCard\VoidRequest $request */
    private $request;

    public function setUp()
    {
        parent::setUp();
        $this->request = new VoidRequest($this->getHttpClient(), $this->getHttpRequest());
    }

    public function testGetData()
    {
        $expectedData = [
            'username' => 'tester',
            'password' => 'testpwd',
            'transactionReference' => '1000001',
            'testmode' => 1,
        ];

        $this->request->initialize($expectedData);

        $data = $this->request->getData();
        $this->assertSame($expectedData['transactionReference'], $data['TRANXID']);
        $this->assertSame($expectedData['username'], $data['UN']);
        $this->assertSame($expectedData['password'], $data['PSWD']);
        $this->assertSame('ProcessTranx', $data['METHOD']);
        $this->assertSame('Void', $data['TRANXTYPE']);
        $this->assertSame('Y', $data['TERMS']);
    }
}
