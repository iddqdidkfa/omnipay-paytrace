<?php

namespace Omnipay\Paytrace\Message;

use Omnipay\Common\Message\RequestInterface;

class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    public function __construct(RequestInterface $request, $data)
    {
        $parsedData = [];
        $responseArr = explode('|', $data);
        foreach ($responseArr as $pair) {
            $tmp = explode('~', $pair);
            $parsedData[$tmp[0]] = $tmp[1];
        }
        parent::__construct($request, $parsedData);
    }

    public function isSuccessful()
    {
        return false;
    }

    public function getTransactionReference()
    {
        return isset($this->data['TRANSACTIONID']) ? $this->data['TRANSACTIONID'] : null;
    }

    public function getMessage()
    {
        if ($this->isSuccessful()) {
            return isset($this->data['RESPONSE']) ? substr($this->data['RESPONSE'], 5) : null;
        } else {
            if (substr($this->data['ERROR'], 0, 4) == '9102') {
                return substr($this->data['ERROR'], 9);
            } else {
                return substr($this->data['ERROR'], 4);
            }
        }
    }

    public function getCode()
    {
        if ($this->isSuccessful()) {
            return isset($this->data['RESPONSE']) ? substr($this->data['RESPONSE'], 0, 3) : null;
        } else {
            if (substr($this->data['ERROR'], 0, 4) == '9102') {
                return substr($this->data['ERROR'], 5, 2);
            } else {
                return substr($this->data['ERROR'], 0, 2);
            }
        }
    }
}