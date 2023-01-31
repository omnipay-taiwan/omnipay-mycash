<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    public function isSuccessful()
    {
        return $this->getCode() === '1';
    }

    public function getMessage()
    {
        return $this->data['RtnMessage'] ?? null;
    }

    public function getCode()
    {
        return (string) $this->data['RtnCode'];
    }

    public function getTransactionId()
    {
        return $this->data['MerTradeID'];
    }
}
