<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class AuthorizeRequest extends AbstractRequest
{
    protected $type = 'Authorization';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\AuthorizeResponse';

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('amount');
        $data = $this->getBaseData();
        if ($this->getCardReference()) {
            $data['CUSTID'] = $this->getCardReference();
        } else {
            $this->validate('card');
            $this->getCard()->validate();
            $card = $this->getCard();
            $data['CC'] = $card->getNumber();
            $data['EXPYR'] = substr($card->getExpiryYear(), -2);
            $data['EXPMNTH'] = str_pad($card->getExpiryMonth(), 2, '0', STR_PAD_LEFT);
        }
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return array_merge($data, $this->getBillingData());
    }
}
