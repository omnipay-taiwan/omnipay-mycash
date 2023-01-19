<?php

namespace Omnipay\MyCash\Traits;

trait HasDefaults
{
    public function getMerTradeID()
    {
        return $this->getTransactionId();
    }

    public function setMerTradeID($value)
    {
        return $this->setTransactionId($value);
    }

    public function getMerProductID()
    {
        return $this->getParameter('MerProductID');
    }

    public function setMerProductID($value)
    {
        return $this->setParameter('MerProductID', $value);
    }

    public function getMerUserID()
    {
        return $this->getParameter('MerUserID');
    }

    public function setMerUserID($value)
    {
        return $this->setParameter('MerUserID', $value);
    }

    public function getTradeDesc()
    {
        return $this->getDescription();
    }

    public function setTradeDesc($value)
    {
        return $this->setDescription($value);
    }

    public function getItemName()
    {
        return $this->getParameter('ItemName');
    }

    public function setItemName($value)
    {
        return $this->setParameter('ItemName', $value);
    }
}
