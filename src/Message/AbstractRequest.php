<?php

namespace Omnipay\Paytrace\Message;

class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $responseClass;
    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {

    }

    public function sendData($data)
    {
        $httpResponse = $this->httpClient->post($this->getEndpoint(), null, $data)->send();
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

    protected function getBaseData()
    {
        return [
            'TERMS' => 'Y',
            'UN' => $this->getUserName(),
            'PSWD' => $this->getPassword(),
        ];
    }

    protected function getBillingData()
    {
        $data = [
            'AMOUNT' => $this->getAmount(),
            'DESCRIPTION' => $this->getDescription(),
            'INVOICE' => $this->getInvoiceId(),
        ];

        if ($card = $this->getCard()) {
            $data['BNAME'] = $card->getBillingName();
            $data['PHONE'] = $card->getPhone();
            $data['EMAIL'] = $card->getEmail();

            $data['BADDRESS'] = $card->getBillingAddress1();
            $data['BADDRESS2'] = $card->getBillingAddress2();
            $data['BCITY'] = $card->getBillingCity();
            $data['BCOUNTRY'] = $card->getBillingCountry();
            $data['BSTATE'] = $card->getBillingState();
            $data['BZIP'] = $card->getBillingPostcode();

            $data['SADDRESS'] = $card->getShippingAddress1();
            $data['SADDRESS2'] = $card->getShippingAddress2();
            $data['SCITY'] = $card->getShippingCity();
            $data['SCOUNTRY'] = $card->getShippingCountry();
            $data['SSTATE'] = $card->getShippingState();
            $data['SZIP'] = $card->getShippingPostcode();
        }

        return $data;
    }

    protected function preparePostData($data)
    {
        $postData = '';
        foreach ($data as $key => $value) {
            $postData .= urlencode("{$key}~{$value}|");
        }
        return $postData;
    }
}