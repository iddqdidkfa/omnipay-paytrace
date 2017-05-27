<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class RefundRequest extends AbstractRequest
{
    protected $type = 'Refund';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\CaptureResponse';

    public function getData()
    {
        if ($this->getCard()) {
            $this->validate('amount', 'card');
            $this->getCard()->validate();
            $data = $this->getBaseData();
            $data['AMOUNT'] = $this->getAmount();
            $data = array_merge($data, $this->getCardData());
            if ($this->getTestMode()) {
                $data['TEST'] = 'Y';
            }
        } else {
            $this->validate('transactionReference');
            $data = $this->getBaseData();
            $data['TRANXID'] = $this->getTransactionReference();
            if ($this->getAmount()) {
                $data['AMOUNT'] = $this->getAmount();
            }
        }
        return $data;
    }
}
