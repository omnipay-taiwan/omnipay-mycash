<?php

namespace Omnipay\MyCash\Message;

class GetPaymentInfoResponse extends CompletePurchaseResponse
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }
}
