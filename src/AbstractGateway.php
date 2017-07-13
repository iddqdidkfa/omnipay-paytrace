<?php

namespace Omnipay\Paytrace;

class AbstractGateway extends \Omnipay\Common\AbstractGateway
{
    const GATEWAY_TYPE = '';

    public function getName()
    {
        return 'PayTrace Check'; // @codeCoverageIgnore
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
        return $this->createRequest(
            '\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\AuthorizeRequest',
            $params
        );
    }

    public function createCard(array $params = [])
    {
        return $this->createRequest(
            '\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\CreateCardRequest',
            $params
        );
    }

    public function updateCard(array $params = [])
    {
        return $this->createRequest(
            '\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\UpdateCardRequest',
            $params
        );
    }

    public function capture(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\CaptureRequest', $params);
    }

    public function purchase(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\PurchaseRequest', $params);
    }

    public function void(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\VoidRequest', $params);
    }

    public function refund(array $params = [])
    {
        return $this->createRequest('\Omnipay\Paytrace\Message\\' . static::GATEWAY_TYPE . '\RefundRequest', $params);
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
