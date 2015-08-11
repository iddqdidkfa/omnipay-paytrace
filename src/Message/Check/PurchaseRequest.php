<?php

namespace Omnipay\Paytrace\Message\Check;

class PurchaseRequest extends AuthorizeRequest
{
    protected $type = 'Sale';
}
