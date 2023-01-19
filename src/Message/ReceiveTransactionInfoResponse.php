<?php

namespace Omnipay\MyCash\Message;

class ReceiveTransactionInfoResponse extends CompletePurchaseResponse
{
    public function isSuccessful()
    {
        return $this->getCode() === '5';
    }
}
