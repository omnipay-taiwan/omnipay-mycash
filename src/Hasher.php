<?php

namespace Omnipay\MyCash;

class Hasher
{
    private $hashKey;

    private $validateKey;

    public function __construct($hashKey, $validateKey)
    {
        $this->hashKey = $hashKey;
        $this->validateKey = $validateKey;
    }

    public function make(array $data)
    {
        $columns = [
            'ValidateKey' => $this->validateKey,
            'HashKey' => $this->hashKey,
            'RtnCode' => $data['RtnCode'],
            'TradeID' => $data['TradeID'],
            'UserID' => $data['UserID'],
            'Money' => $data['Money'],
        ];

        $results = [];
        foreach ($columns as $key => $value) {
            $results[] = "$key=$value";
        }

        return md5(implode('&', $results));
    }
}
