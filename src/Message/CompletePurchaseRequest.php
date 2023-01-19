<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasDefaults;
use Omnipay\MyCash\Traits\HasMyCash;

class CompletePurchaseRequest extends AbstractRequest
{
    use HasMyCash;
    use HasDefaults;

    public function getRtnCode()
    {
        return $this->getParameter('RtnCode');
    }

    public function setRtnCode($value)
    {
        return $this->setParameter('RtnCode', $value);
    }

    public function getRtnMessage()
    {
        return $this->getParameter('RtnMessage');
    }

    public function setRtnMessage($value)
    {
        return $this->setParameter('RtnMessage', $value);
    }

    public function getPaymentDate()
    {
        return $this->getParameter('PaymentDate');
    }

    public function setPaymentDate($value)
    {
        return $this->setParameter('PaymentDate', $value);
    }

    public function getValidate()
    {
        return $this->getParameter('Validate');
    }

    public function setValidate($value)
    {
        return $this->setParameter('Validate', $value);
    }

    public function getAuthCode()
    {
        return $this->getParameter('Auth_code');
    }

    public function setAuthCode($value)
    {
        return $this->setParameter('Auth_code', $value);
    }

    public function getCardNumber()
    {
        return $this->getParameter('CardNumber');
    }

    public function setCardNumber($value)
    {
        return $this->setParameter('CardNumber', $value);
    }

    /**
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionId', 'MerProductID', 'MerUserID', 'amount', 'PaymentDate', 'Validate');

        if ($this->makeHash() !== $this->getValidate()) {
            throw new InvalidRequestException('validate fails');
        }

        return [
            'RtnCode' => $this->getRtnCode(),
            'RtnMessage' => $this->getRtnMessage(),
            'MerTradeID' => $this->getTransactionId(),
            'MerProductID' => $this->getMerProductID(),
            'MerUserID' => $this->getMerUserID(),
            'Amount' => (int) $this->getAmount(),
            'Auth_code' => $this->getAuthCode(),
            'CardNumber' => $this->getCardNumber(),
            'PaymentDate' => $this->getPaymentDate(),
            'Validate' => $this->getValidate(),
        ];
    }

    public function sendData($data)
    {
        return $this->response = new CompletePurchaseResponse($this, $data);
    }

    private function makeHash(): string
    {
        $columns = [
            'ValidateKey' => $this->getValidateKey(),
            'HashKey' => $this->getHashKey(),
            'RtnCode' => $this->getRtnCode(),
            'TradeID' => $this->getTransactionId(),
            'UserID' => $this->getMerUserID(),
            'Money' => (int) $this->getAmount(),
        ];

        $results = [];
        foreach ($columns as $key => $value) {
            $results[] = "$key=$value";
        }

        return md5(implode('&', $results));
    }
}
