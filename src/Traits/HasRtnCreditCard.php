<?php

namespace Omnipay\MyCash\Traits;

trait HasRtnCreditCard
{
    public function getAuthCode()
    {
        return $this->getParameter('Auth_code');
    }

    public function setAuthCode($value)
    {
        return $this->setParameter('Auth_code', $value);
    }

    public function getCardNumber()
    {
        return $this->getParameter('CardNumber');
    }

    public function setCardNumber($value)
    {
        return $this->setParameter('CardNumber', $value);
    }
}
