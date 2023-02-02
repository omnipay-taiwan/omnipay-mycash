<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Message\AbstractResponse;

class CompletePurchaseResponse extends AbstractResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() === '1';
    }

    /**
     * @return string|null
     */
    public function getMessage()
    {
        return $this->data['RtnMessage'] ?? null;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return (string) $this->data['RtnCode'];
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->data['MerTradeID'];
    }
}
