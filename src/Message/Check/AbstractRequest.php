<?php

namespace Omnipay\Paytrace\Message\Check;

use Omnipay\Paytrace\Check;

abstract class AbstractRequest extends \Omnipay\Paytrace\Message\AbstractRequest
{
    protected $responseClass = 'Omnipay\Paytrace\Message\Check\Response';

    /**
     * @return \Omnipay\Paytrace\Check
     */
    public function getCheck()
    {
        return $this->getParameter('check');
    }

    public function setCheck($value)
    {
        if ($value && !$value instanceof Check) {
            $value = new Check($value);
        }

        return $this->setParameter('check', $value);
    }

    protected function getBillingSource()
    {
        return $this->getCheck();
    }

    protected function getBaseData()
    {
        return [
            'TERMS' => 'Y',
            'UN' => $this->getUserName(),
            'PSWD' => $this->getPassword(),
            'METHOD' => $this->method,
            'CHECKTYPE' => $this->type,
        ];
    }
}
