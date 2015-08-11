<?php

namespace Omnipay\Paytrace;

use Omnipay\Common\Helper;
use Omnipay\Paytrace\Exception\InvalidCheckException;
use Symfony\Component\HttpFoundation\ParameterBag;

class Check
{
    /** @var ParameterBag $parameters */
    protected $parameters;

    public function __construct($parameters = null)
    {
        $this->initialize($parameters);
    }

    public function initialize($parameters = null)
    {
        $this->parameters = new ParameterBag;
        Helper::initialize($this, $parameters);

        return $this;
    }

    public function getParameters()
    {
        return $this->parameters->all();
    }

    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    protected function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);

        return $this;
    }

    public function getRoutingNumber()
    {
        return $this->getParameter('routingNumber');
    }

    public function setRoutingNumber($value)
    {
        return $this->setParameter('routingNumber', $value);
    }

    public function getBankAccount()
    {
        return $this->getParameter('bankAccount');
    }

    public function setBankAccount($value)
    {
        return $this->setParameter('bankAccount', $value);
    }

    public function validate()
    {
        foreach (['routingNumber', 'bankAccount', 'billingFirstName', 'billingLastName'] as $key) {
            if (!$this->getParameter($key)) {
                throw new InvalidCheckException("The $key parameter is required");
            }
        }

        if (strlen($this->getRoutingNumber()) !== 9) {
            throw new InvalidCheckException("Invalid Bank Routing Number");
        }
    }

    public function getFirstName()
    {
        return $this->getBillingFirstName();
    }

    public function setFirstName($value)
    {
        $this->setBillingFirstName($value);
        $this->setShippingFirstName($value);

        return $this;
    }

    public function getLastName()
    {
        return $this->getBillingLastName();
    }

    public function setLastName($value)
    {
        $this->setBillingLastName($value);
        $this->setShippingLastName($value);

        return $this;
    }

    public function getName()
    {
        return $this->getBillingName();
    }

    public function setName($value)
    {
        $this->setBillingName($value);
        $this->setShippingName($value);

        return $this;
    }

    public function getBillingName()
    {
        return trim($this->getBillingFirstName() . ' ' . $this->getBillingLastName());
    }

    public function setBillingName($value)
    {
        $names = explode(' ', $value, 2);
        $this->setBillingFirstName($names[0]);
        $this->setBillingLastName(isset($names[1]) ? $names[1] : null);

        return $this;
    }

    public function getBillingFirstName()
    {
        return $this->getParameter('billingFirstName');
    }

    public function setBillingFirstName($value)
    {
        return $this->setParameter('billingFirstName', $value);
    }

    public function getBillingLastName()
    {
        return $this->getParameter('billingLastName');
    }

    public function setBillingLastName($value)
    {
        return $this->setParameter('billingLastName', $value);
    }

    public function getBillingCompany()
    {
        return $this->getParameter('billingCompany');
    }

    public function setBillingCompany($value)
    {
        return $this->setParameter('billingCompany', $value);
    }

    public function getBillingAddress1()
    {
        return $this->getParameter('billingAddress1');
    }

    public function setBillingAddress1($value)
    {
        return $this->setParameter('billingAddress1', $value);
    }

    public function getBillingAddress2()
    {
        return $this->getParameter('billingAddress2');
    }

    public function setBillingAddress2($value)
    {
        return $this->setParameter('billingAddress2', $value);
    }

    public function getBillingCity()
    {
        return $this->getParameter('billingCity');
    }

    public function setBillingCity($value)
    {
        return $this->setParameter('billingCity', $value);
    }

    public function getBillingPostcode()
    {
        return $this->getParameter('billingPostcode');
    }

    public function setBillingPostcode($value)
    {
        return $this->setParameter('billingPostcode', $value);
    }

    public function getBillingState()
    {
        return $this->getParameter('billingState');
    }

    public function setBillingState($value)
    {
        return $this->setParameter('billingState', $value);
    }

    public function getBillingCountry()
    {
        return $this->getParameter('billingCountry');
    }

    public function setBillingCountry($value)
    {
        return $this->setParameter('billingCountry', $value);
    }

    public function getBillingPhone()
    {
        return $this->getParameter('billingPhone');
    }

    public function setBillingPhone($value)
    {
        return $this->setParameter('billingPhone', $value);
    }

    public function getBillingFax()
    {
        return $this->getParameter('billingFax');
    }

    public function setBillingFax($value)
    {
        return $this->setParameter('billingFax', $value);
    }

    public function getShippingTitle()
    {
        return $this->getParameter('shippingTitle');
    }

    public function setShippingTitle($value)
    {
        return $this->setParameter('shippingTitle', $value);
    }

    public function getShippingName()
    {
        return trim($this->getShippingFirstName() . ' ' . $this->getShippingLastName());
    }

    public function setShippingName($value)
    {
        $names = explode(' ', $value, 2);
        $this->setShippingFirstName($names[0]);
        $this->setShippingLastName(isset($names[1]) ? $names[1] : null);

        return $this;
    }

    public function getShippingFirstName()
    {
        return $this->getParameter('shippingFirstName');
    }

    public function setShippingFirstName($value)
    {
        return $this->setParameter('shippingFirstName', $value);
    }

    public function getShippingLastName()
    {
        return $this->getParameter('shippingLastName');
    }

    public function setShippingLastName($value)
    {
        return $this->setParameter('shippingLastName', $value);
    }

    public function getShippingCompany()
    {
        return $this->getParameter('shippingCompany');
    }

    public function setShippingCompany($value)
    {
        return $this->setParameter('shippingCompany', $value);
    }

    public function getShippingAddress1()
    {
        return $this->getParameter('shippingAddress1');
    }

    public function setShippingAddress1($value)
    {
        return $this->setParameter('shippingAddress1', $value);
    }

    public function getShippingAddress2()
    {
        return $this->getParameter('shippingAddress2');
    }

    public function setShippingAddress2($value)
    {
        return $this->setParameter('shippingAddress2', $value);
    }

    public function getShippingCity()
    {
        return $this->getParameter('shippingCity');
    }

    public function setShippingCity($value)
    {
        return $this->setParameter('shippingCity', $value);
    }

    public function getShippingPostcode()
    {
        return $this->getParameter('shippingPostcode');
    }

    public function setShippingPostcode($value)
    {
        return $this->setParameter('shippingPostcode', $value);
    }

    public function getShippingState()
    {
        return $this->getParameter('shippingState');
    }

    public function setShippingState($value)
    {
        return $this->setParameter('shippingState', $value);
    }

    public function getShippingCountry()
    {
        return $this->getParameter('shippingCountry');
    }

    public function setShippingCountry($value)
    {
        return $this->setParameter('shippingCountry', $value);
    }

    public function getShippingPhone()
    {
        return $this->getParameter('shippingPhone');
    }

    public function setShippingPhone($value)
    {
        return $this->setParameter('shippingPhone', $value);
    }

    public function getShippingFax()
    {
        return $this->getParameter('shippingFax');
    }

    public function setShippingFax($value)
    {
        return $this->setParameter('shippingFax', $value);
    }

    public function getAddress1()
    {
        return $this->getParameter('billingAddress1');
    }

    public function setAddress1($value)
    {
        $this->setParameter('billingAddress1', $value);
        $this->setParameter('shippingAddress1', $value);

        return $this;
    }

    public function getAddress2()
    {
        return $this->getParameter('billingAddress2');
    }

    public function setAddress2($value)
    {
        $this->setParameter('billingAddress2', $value);
        $this->setParameter('shippingAddress2', $value);

        return $this;
    }

    public function getCity()
    {
        return $this->getParameter('billingCity');
    }

    public function setCity($value)
    {
        $this->setParameter('billingCity', $value);
        $this->setParameter('shippingCity', $value);

        return $this;
    }

    public function getPostcode()
    {
        return $this->getParameter('billingPostcode');
    }

    public function setPostcode($value)
    {
        $this->setParameter('billingPostcode', $value);
        $this->setParameter('shippingPostcode', $value);

        return $this;
    }

    public function getState()
    {
        return $this->getParameter('billingState');
    }

    public function setState($value)
    {
        $this->setParameter('billingState', $value);
        $this->setParameter('shippingState', $value);

        return $this;
    }

    public function getCountry()
    {
        return $this->getParameter('billingCountry');
    }

    public function setCountry($value)
    {
        $this->setParameter('billingCountry', $value);
        $this->setParameter('shippingCountry', $value);

        return $this;
    }

    public function getPhone()
    {
        return $this->getParameter('billingPhone');
    }

    public function setPhone($value)
    {
        $this->setParameter('billingPhone', $value);
        $this->setParameter('shippingPhone', $value);

        return $this;
    }

    public function getFax()
    {
        return $this->getParameter('billingFax');
    }

    public function setFax($value)
    {
        $this->setParameter('billingFax', $value);
        $this->setParameter('shippingFax', $value);

        return $this;
    }

    public function getCompany()
    {
        return $this->getParameter('billingCompany');
    }

    public function setCompany($value)
    {
        $this->setParameter('billingCompany', $value);
        $this->setParameter('shippingCompany', $value);

        return $this;
    }

    public function getEmail()
    {
        return $this->getParameter('email');
    }

    public function setEmail($value)
    {
        return $this->setParameter('email', $value);
    }
}
