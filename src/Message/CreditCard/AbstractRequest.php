<?php

namespace Omnipay\Paytrace\Message\CreditCard;

abstract class AbstractRequest extends \Omnipay\Paytrace\Message\AbstractRequest
{
    protected $method = 'ProcessTranx';

    protected function getBillingSource()
    {
        return $this->getCard();
    }

    protected function getBaseData()
    {
        return [
            'TERMS' => 'Y',
            'UN' => $this->getUserName(),
            'PSWD' => $this->getPassword(),
            'METHOD' => $this->method,
            'TRANXTYPE' => $this->type,
        ];
    }
}
