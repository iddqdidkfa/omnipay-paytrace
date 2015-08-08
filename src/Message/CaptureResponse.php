<?php

namespace Omnipay\Paytrace\Message;

class CaptureResponse extends AbstractResponse
{
    /**
     * @inheritdoc
     */
    public function isSuccessful()
    {
        return !isset($this->data['ERROR']) || empty($this->data['ERROR']);
    }
}