<?php

namespace Omnipay\MyCash\Traits;

use Omnipay\MyCash\Hasher;

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

    public function getMerTradeID()
    {
        return $this->getTransactionId();
    }

    public function setMerTradeID($value)
    {
        return $this->setTransactionId($value);
    }

    /**
     * @return string
     */
    private function makeHash(array $data)
    {
        $hasher = new Hasher($this->getHashKey(), $this->getValidateKey());

        return $hasher->make([
            'RtnCode' => $data['RtnCode'],
            'TradeID' => $data['MerTradeID'],
            'UserID' => $data['MerUserID'],
            'Money' => $data['Amount'],
        ]);
    }
}
