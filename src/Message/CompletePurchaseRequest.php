<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasDefaults;
use Omnipay\MyCash\Traits\HasMyCash;
use Omnipay\MyCash\Traits\HasRtn;
use Omnipay\MyCash\Traits\HasRtnATM;
use Omnipay\MyCash\Traits\HasRtnCreditCard;
use Omnipay\MyCash\Traits\HasRtnCVS;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasMyCash;
    use HasDefaults;
    use HasRtn;
    use HasRtnCreditCard;
    use HasRtnATM;
    use HasRtnCVS;

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionId', 'MerProductID', 'MerUserID', 'amount', 'PaymentDate', 'Validate');

        $data = [
            'RtnCode' => $this->getRtnCode(),
            'RtnMessage' => $this->getRtnMessage(),
            'MerTradeID' => $this->getTransactionId(),
            'MerProductID' => $this->getMerProductID(),
            'MerUserID' => $this->getMerUserID(),
            'Amount' => (int) $this->getAmount(),
            'Auth_code' => $this->getAuthCode(),
            'CardNumber' => $this->getCardNumber(),
            'PaymentDate' => $this->getPaymentDate(),
            'ATMNo' => $this->getATMNo(),
            'StoreName' => $this->getStoreName(),
            'StoreID' => $this->getStoreID(),
            'Validate' => $this->getValidate(),
        ];

        if ($this->makeHash($data) !== $this->getValidate()) {
            throw new InvalidRequestException('validate fails');
        }

        return array_filter($data, static function ($value) {
            return ! empty($value);
        });
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    private function makeHash(array $data): string
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
