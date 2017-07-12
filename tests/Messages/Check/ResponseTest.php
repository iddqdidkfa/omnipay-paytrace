<?php

namespace Omnipay\Paytrace\Message\Check;

use Omnipay\Tests\TestCase;

class ResponseTest extends TestCase
{
    public function testSuccess()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/Check/ResponseSuccess.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
        $this->assertTrue($response->isSuccessful());
        $this->assertSame('121', $response->getCode());
        $this->assertSame(
            'Your TEST check was successfully processed. HOWEVER, FUNDS WILL NOT BE TRANSFERRED.',
            $response->getMessage()
        );
    }

    public function testFail()
    {
        $httpResponse = $this->getMockHttpResponse('../../../Mock/Check/ResponseFailed.txt');
        $response = new Response($this->getMockRequest(), $httpResponse->getBody());
        $this->assertFalse($response->isSuccessful());
        $this->assertSame('998', $response->getCode());
        $this->assertSame('Log in failed.', $response->getMessage());
    }
}
