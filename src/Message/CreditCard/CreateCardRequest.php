<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class CreateCardRequest extends AuthorizeRequest
{
    protected $type = 'CreateCustomer';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\CreateCardResponse';

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('card');
        $this->getCard()->validate();
        $data = $this->getBaseData();
        $card = $this->getCard();
        $data['CC'] = $card->getNumber();
        $data['EXPYR'] = substr($card->getExpiryYear(), -2);
        $data['EXPMNTH'] = str_pad($card->getExpiryMonth(), 2, '0', STR_PAD_LEFT);
        $data['CUSTID'] = $this->getCardReference();
        $data['METHOD'] = $this->type;
        unset($data['TRANXTYPE']);
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return array_merge($data, $this->getBillingData());
    }
}
