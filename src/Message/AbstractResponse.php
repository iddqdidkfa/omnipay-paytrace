<?php

namespace Omnipay\Paytrace\Message;

use Omnipay\Common\Message\RequestInterface;

abstract class AbstractResponse extends \Omnipay\Common\Message\AbstractResponse
{
    const TRANSACTION_KEY = '';

    public function __construct(RequestInterface $request, $data)
    {
        $parsedData = [];
        $responseArr = explode('|', (string)$data);
        foreach ($responseArr as $pair) {
            if (strlen(trim($pair)) == 0) {
                continue;
            }
            $tmp = explode('~', $pair);
            $parsedData[$tmp[0]] = $tmp[1];
        }
        parent::__construct($request, $parsedData);
    }

    public function getTransactionReference()
    {
        return isset($this->data[static::TRANSACTION_KEY]) ? $this->data[static::TRANSACTION_KEY] : null;
    }

    public function getMessage()
    {
        if ($this->isSuccessful()) {
            return isset($this->data['RESPONSE']) ? substr($this->data['RESPONSE'], 5) : null;
        } else {
            if (isset($this->data['ERROR'])) {
                $errorParts = explode('. ', $this->data['ERROR'], 2);
            } else {
                $errorParts = explode('. ', $this->data['RESPONSE'], 2);
            }
            return (count($errorParts) == 2) ? $errorParts[1] : null;
        }
    }

    public function getCode()
    {
        if ($this->isSuccessful()) {
            return isset($this->data['RESPONSE']) ? substr($this->data['RESPONSE'], 0, 3) : null;
        } else {
            if (isset($this->data['ERROR'])) {
                $errorParts = explode('. ', $this->data['ERROR'], 2);
            } else {
                $errorParts = explode('. ', $this->data['RESPONSE'], 2);
            }
            return (count($errorParts) == 2) ? $errorParts[0] : null;
        }
    }
}
