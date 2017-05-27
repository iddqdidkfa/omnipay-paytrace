<?php

namespace Omnipay\Paytrace\Message\Check;

class CreateCardRequest extends AuthorizeRequest
{
    protected $type = 'CreateCustomer';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\CreateCardResponse';

    /**
     * @inheritdoc
     */
    public function getData()
    {
        $this->validate('check');
        $check = $this->getCheck();
        $check->validate();
        $data = $this->getBaseData();
        $data['DDA'] = $check->getBankAccount();
        $data['TR'] = $check->getRoutingNumber();
        $data['CUSTID'] = $this->getCardReference();
        $data['METHOD'] = $this->type;
        unset($data['TRANXTYPE']);
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return array_merge($data, $this->getBillingData());
    }
}
