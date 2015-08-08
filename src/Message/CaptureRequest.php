<?php

namespace Omnipay\Paytrace\Message;

class CaptureRequest extends AbstractRequest
{
    protected $type = 'Capture';
    protected $responseClass = 'CaptureResponse';

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