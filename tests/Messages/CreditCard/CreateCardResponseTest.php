<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class CreateCardResponseTest extends TestCase
{
    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/CreateCardResponseSuccess.txt');
        $response = new CreateCardResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('160', $response->getCode());
        $this->assertSame(
            'The customer profile for 14496097\/John Doe was successfully created.',
            $response->getMessage()
        );
    }

    public function testFail()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/ResponseFailed.txt');
        $response = new CreateCardResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }
}
