<?php

namespace Omnipay\Paytrace\Message\CreditCard;

class PurchaseRequest extends AuthorizeRequest
{
    protected $type = 'Sale';
}
