<?php

namespace Omnipay\Paytrace\Message\Check;

class CaptureRequest extends AbstractRequest
{
    protected $method = 'ManageCheck';
    protected $type = 'Fund';

    public function getData()
    {
        $this->validate('transactionReference');
        $data = $this->getBaseData();
        $data['CHECKID'] = $this->getTransactionReference();
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return $data;
    }
}
