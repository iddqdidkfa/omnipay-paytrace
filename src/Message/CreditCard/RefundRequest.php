<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class RefundRequest extends AbstractRequest
{
    protected $type = 'Refund';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\CaptureResponse';

    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();
        $data = $this->getBaseData();
        $card = $this->getCard();
        $data['AMOUNT'] = $this->getAmount();
        $data['CC'] = $card->getNumber();
        $data['EXPYR'] = substr($card->getExpiryYear(), -2);
        $data['EXPMNTH'] = str_pad($card->getExpiryMonth(), 2, '0', STR_PAD_LEFT);
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return $data;
    }
}
