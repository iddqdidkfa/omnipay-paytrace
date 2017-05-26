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
            $data = array_merge($data, $this->getCardData());
        }
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return array_merge($data, $this->getBillingData());
    }
}
