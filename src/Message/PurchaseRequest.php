<?php

namespace Omnipay\Paytrace\Message;

class PurchaseRequest extends AuthorizeRequest
{
    protected $type = 'Sale';
}