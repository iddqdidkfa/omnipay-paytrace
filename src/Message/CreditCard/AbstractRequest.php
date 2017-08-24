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

    protected function getCardData()
    {
        $this->validate('card');
        $this->getCard()->validate();
        $card = $this->getCard();
        $data = array();
        $data['CC'] = $card->getNumber();
        $data['EXPYR'] = substr($card->getExpiryYear(), -2);
        $data['EXPMNTH'] = str_pad($card->getExpiryMonth(), 2, '0', STR_PAD_LEFT);
        $data['CSC'] = $card->getCvv();
        return $data;
    }
}
