<?php

namespace Omnipay\MyCash\Traits;

trait HasRtn
{
    public function getRtnCode()
    {
        return $this->getParameter('RtnCode');
    }

    public function setRtnCode($value)
    {
        return $this->setParameter('RtnCode', $value);
    }

    public function getRtnMessage()
    {
        return $this->getParameter('RtnMessage');
    }

    public function setRtnMessage($value)
    {
        return $this->setParameter('RtnMessage', $value);
    }

    public function getPaymentDate()
    {
        return $this->getParameter('PaymentDate');
    }

    public function setPaymentDate($value)
    {
        return $this->setParameter('PaymentDate', $value);
    }

    public function getValidate()
    {
        return $this->getParameter('Validate');
    }

    public function setValidate($value)
    {
        return $this->setParameter('Validate', $value);
    }
}
