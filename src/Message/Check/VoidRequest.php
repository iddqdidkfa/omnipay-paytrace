<?php

namespace Omnipay\Paytrace\Message\Check;

class VoidRequest extends CaptureRequest
{
    protected $type = 'Void';
}
