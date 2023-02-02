<?php

namespace Omnipay\MyCash\Message;

class ReceiveTransactionInfoResponse extends CompletePurchaseResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getCode() === '5';
    }
}
