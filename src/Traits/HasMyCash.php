<?php

namespace Omnipay\MyCash\Traits;

trait HasMyCash
{
    public function getHashKey()
    {
        return $this->getParameter('HashKey');
    }

    public function setHashKey($value)
    {
        return $this->setParameter('HashKey', $value);
    }

    public function getHashIV()
    {
        return $this->getParameter('HashIV');
    }

    public function setHashIV($value)
    {
        return $this->setParameter('HashIV', $value);
    }
    public function getValidateKey()
    {
        return $this->getParameter('ValidateKey');
    }

    public function setValidateKey($value)
    {
        return $this->setParameter('ValidateKey', $value);
    }
}
