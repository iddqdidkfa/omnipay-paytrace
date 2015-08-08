<?php

namespace Omnipay\Paytrace\Message;

class VoidRequest extends CaptureRequest
{
    protected $type = 'Void';
}