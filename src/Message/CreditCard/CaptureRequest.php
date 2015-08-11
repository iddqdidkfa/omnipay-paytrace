<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class CaptureRequest extends AbstractRequest
{
    protected $type = 'Capture';
    protected $responseClass = 'Omnipay\Paytrace\Message\CreditCard\CaptureResponse';

    public function getData()
    {
        $this->validate('transactionReference');
        $data = $this->getBaseData();
        $data['TRANXID'] = $this->getTransactionReference();
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return $data;
    }
}
