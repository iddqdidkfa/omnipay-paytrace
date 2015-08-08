<?php

namespace Omnipay\Paytrace\Message;

class AuthorizeRequest extends AbstractRequest
{
    protected $method = 'ProcessTranx';
    protected $type = 'Authorization';
    protected $responseClass = 'AuthorizeResponse';

    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate('amount', 'card');
        $this->getCard()->validate();
        $data = $this->getBaseData();
        $card = $this->getCard();
        $data['CC'] = $card->getNumber();
        $data['EXPMNTH'] = substr($card->getExpiryYear(), -2);
        $data['EXPYR'] = $card->getExpiryMonth();
        if ($this->getTestMode()) {
            $data['TEST'] = 'Y';
        }
        return array_merge($data, $this->getBillingData());
    }
}