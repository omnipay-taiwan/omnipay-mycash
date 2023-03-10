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

    public function getMerTradeID()
    {
        return $this->getTransactionId();
    }

    public function setMerTradeID($value)
    {
        return $this->setTransactionId($value);
    }

    /**
     * @param  array  $data
     * @return string
     */
    private function makeHash(array $data)
    {
        $columns = [
            'ValidateKey' => $this->getValidateKey(),
            'HashKey' => $this->getHashKey(),
            'RtnCode' => $data['RtnCode'],
            'TradeID' => $data['MerTradeID'],
            'UserID' => $data['MerUserID'],
            'Money' => $data['Amount'],
        ];

        $results = [];
        foreach ($columns as $key => $value) {
            $results[] = "$key=$value";
        }

        return md5(implode('&', $results));
    }
}
