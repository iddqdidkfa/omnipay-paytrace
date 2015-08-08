<?php

namespace Omnipay\Paytrace;

use Omnipay\Common\AbstractGateway;

class Gateway extends AbstractGateway
{
    /**
     * Get gateway display name
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName()
    {
        return 'PayTrace';
    }

    public function getDefaultParameters()
    {
        return array(
            'username' => '',
            'password' => '',
            'testMode' => false,
            'endpoint' => 'https://paytrace.com/api/default.pay',
        );
    }

    public function authorize(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\AuthorizeRequest', $params);
    }

    public function capture(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\CaptureRequest', $params);
    }

    public function purchase(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\PurchaseRequest', $params);
    }

    public function void(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\VoidRequest', $params);
    }

    public function refund(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\RefundRequest', $params);
    }

    public function getUserName()
    {
        return $this->getParameter('username');
    }

    public function setUserName($value)
    {
        return $this->setParameter('username', $value);
    }

    public function getPassword()
    {
        return $this->getParameter('password');
    }

    public function setPassword($value)
    {
        return $this->setParameter('password', $value);
    }

    public function getEndpoint()
    {
        return $this->getParameter('endpoint');
    }

    public function setEndpoint($value)
    {
        return $this->setParameter('endpoint', $value);
    }
}