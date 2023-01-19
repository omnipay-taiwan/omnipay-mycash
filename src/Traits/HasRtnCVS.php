<?php

namespace Omnipay\MyCash\Traits;

trait HasRtnCVS
{
    public function getStoreName()
    {
        return $this->getParameter('StoreName');
    }

    public function setStoreName($value)
    {
        return $this->setParameter('StoreName', $value);
    }

    public function getStoreID()
    {
        return $this->getParameter('StoreID');
    }

    public function setStoreID($value)
    {
        return $this->setParameter('StoreID', $value);
    }
}
