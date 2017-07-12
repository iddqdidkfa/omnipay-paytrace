<?php

namespace Omnipay\Paytrace\Message\CreditCard;

use Omnipay\Tests\TestCase;

class CaptureResponseTest extends TestCase
{
    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/CaptureResponseSuccess.txt');
        $response = new CaptureResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('114', $response->getCode());
        $this->assertSame(
            'Your TEST transaction was successfully captured. HOWEVER, NO TRANSACTION WAS ACTUALLY CAPTURED.',
            $response->getMessage()
        );
    }

    public function testFail()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/CreditCard/ResponseFailed.txt');
        $response = new CaptureResponse($this->getMockRequest(), $httpResponse->getBody());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }
}
