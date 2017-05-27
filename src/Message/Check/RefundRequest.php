<?php

namespace Omnipay\Paytrace\Message\Check;

class RefundRequest extends AuthorizeRequest
{
    protected $type = 'Refund';

    public function getData()
    {
        if ($this->getCheck()) {
            $this->validate('amount', 'check');
            $check = $this->getCheck();
            $check->validate();
            $data = $this->getBaseData();
            $data['DDA'] = $check->getBankAccount();
            $data['TR'] = $check->getRoutingNumber();
            $data = array_merge($data, $this->getBillingData());
        } else {
            $this->validate('transactionReference');
            $data = $this->getBaseData();
            $data['TRANXID'] = $this->getTransactionReference();
        }
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        if ($this->getAmount()) {
            $data['AMOUNT'] = $this->getAmount();
        }
        return $data;
    }
}
