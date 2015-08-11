<?php

namespace Omnipay\Paytrace;

class CreditCardGateway extends AbstractGateway
{
    const GATEWAY_TYPE = 'CreditCard';

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'PayTrace CreditCard';
    }
}
