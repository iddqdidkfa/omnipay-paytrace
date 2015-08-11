<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class VoidRequest extends CaptureRequest
{
    protected $type = 'Void';
}
