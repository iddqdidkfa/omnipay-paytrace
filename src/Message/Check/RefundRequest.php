<?php

namespace Omnipay\Paytrace\Message\Check;

class RefundRequest extends AuthorizeRequest
{
    protected $type = 'Refund';
}
