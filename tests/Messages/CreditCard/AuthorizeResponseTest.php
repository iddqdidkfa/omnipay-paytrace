<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class AuthorizeResponseTest extends TestCase
{
    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/AuthorizeResponseSuccess.txt');
        $response = new AuthorizeResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('104', $response->getCode());
        $this->assertSame(
            'Your TEST transaction was successfully approved. HOWEVER, A LIVE APPROVAL WAS NOT OBTAINED.',
            $response->getMessage()
        );
    }

    public function testFail()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/AuthorizeResponseFailed.txt');
        $response = new AuthorizeResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('105', $response->getCode());
        $this->assertSame('Your TEST transaction was not approved.', $response->getMessage());
    }
}
