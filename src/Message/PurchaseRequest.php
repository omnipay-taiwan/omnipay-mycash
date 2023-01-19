<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasCreditCard;
use Omnipay\MyCash\Traits\HasDefaults;
use Omnipay\MyCash\Traits\HasMyCash;

class PurchaseRequest extends AbstractRequest
{
    use HasMyCash;
    use HasDefaults;
    use HasCreditCard;


    public function getChoosePayment()
    {
        return $this->getParameter('ChoosePayment');
    }

    public function setChoosePayment($value)
    {
        return $this->setParameter('ChoosePayment', $value);
    }


    public function getData()
    {
        $this->validate('HashKey', 'HashIV', 'transactionId', 'amount', 'description', 'MerProductID', 'MerUserID', 'ItemName');

        return [
            "HashKey" => $this->getHashKey(),
            "HashIV" => $this->getHashIV(),
            "MerTradeID" => $this->getTransactionId(),
            "MerProductID" => $this->getMerProductID(),
            "MerUserID" => $this->getMerUserID(),
            "Amount" => (int) $this->getAmount(),
            "TradeDesc" => $this->getDescription(),
            "ItemName" => $this->getItemName(),
            'UnionPay' => $this->getUnionPay(),
            'Installment' => $this->getInstallment(),
        ];
    }

    public function sendData($data): PurchaseResponse
    {
        return new PurchaseResponse($this, $data);
    }
}
