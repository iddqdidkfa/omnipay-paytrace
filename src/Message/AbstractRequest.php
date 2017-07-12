<?php

namespace Omnipay\Paytrace\Message;

abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $method;
    protected $type;
    protected $responseClass;

    public function sendData($data)
    {
        $headers = [
            'MIME-Version' => '1.0',
            'Content-type' => 'application/x-www-form-urlencoded',
            'Contenttransfer-encoding' => 'text',
        ];
        $httpResponse = $this->httpClient->post(
            $this->getEndpoint(),
            $headers,
            'parmlist=' . $this->preparePostData($data)
        )
            ->send();
        $responseClass = $this->responseClass;
        return $this->response = new $responseClass($this, $httpResponse->getBody());
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

    public function getInvoiceId()
    {
        return $this->getParameter('invoiceId');
    }

    public function setInvoiceId($value)
    {
        return $this->setParameter('invoiceId', $value);
    }

    public function getCardReference()
    {
        return $this->getParameter('custid');
    }

    public function setCardReference($value)
    {
        return $this->setParameter('custid', $value);
    }

    /**
     * @return \Omnipay\Common\CreditCard|\Omnipay\Paytrace\Check
     */
    protected function getBillingSource()
    {
        return null; // @codeCoverageIgnore
    }

    protected function getBillingData()
    {
        $data = [
            'AMOUNT' => $this->getAmount(),
            'DESCRIPTION' => $this->getDescription(),
            'INVOICE' => $this->getInvoiceId(),
        ];

        $source = $this->getBillingSource();
        if (!$source) {
            return $data; // @codeCoverageIgnore
        }

        $data['BNAME'] = $source->getBillingName();
        $data['PHONE'] = $source->getPhone();
        $data['EMAIL'] = $source->getEmail();

        $data['BADDRESS'] = $source->getBillingAddress1();
        $data['BADDRESS2'] = $source->getBillingAddress2();
        $data['BCITY'] = $source->getBillingCity();
        $data['BCOUNTRY'] = $source->getBillingCountry();
        $data['BSTATE'] = $source->getBillingState();
        $data['BZIP'] = $source->getBillingPostcode();

        $data['SADDRESS'] = $source->getShippingAddress1();
        $data['SADDRESS2'] = $source->getShippingAddress2();
        $data['SCITY'] = $source->getShippingCity();
        $data['SCOUNTRY'] = $source->getShippingCountry();
        $data['SSTATE'] = $source->getShippingState();
        $data['SZIP'] = $source->getShippingPostcode();

        return $data;
    }

    protected function preparePostData($data)
    {
        $postData = '';
        foreach ($data as $key => $value) {
            if (empty($value)) {
                continue;
            }
            $postData .= urlencode("{$key}~{$value}|");
        }
        return $postData;
    }
}
