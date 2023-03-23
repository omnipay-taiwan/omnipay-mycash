<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasAmount;
use Omnipay\MyCash\Traits\HasDefaults;
use Omnipay\MyCash\Traits\HasMyCash;
use Omnipay\MyCash\Traits\HasRtn;

class ReceiveTransactionInfoRequest extends AbstractRequest
{
    use HasMyCash;
    use HasDefaults;
    use HasRtn;
    use HasAmount;

    /**
     * @return string
     */
    public function getExpireTime()
    {
        return $this->getParameter('ExpireTime');
    }

    /**
     * @param  string  $value
     * @return ReceiveTransactionInfoRequest
     */
    public function setExpireTime($value)
    {
        return $this->setParameter('ExpireTime', $value);
    }

    /**
     * @return string
     */
    public function getVatmBankCode()
    {
        return $this->getParameter('VatmBankCode');
    }

    /**
     * @param  string  $value
     * @return ReceiveTransactionInfoRequest
     */
    public function setVatmBankCode($value)
    {
        return $this->setParameter('VatmBankCode', $value);
    }

    /**
     * @return string
     */
    public function getVatmAccount()
    {
        return $this->getParameter('VatmAccount');
    }

    /**
     * @param  string  $value
     * @return ReceiveTransactionInfoRequest
     */
    public function setVatmAccount($value)
    {
        return $this->setParameter('VatmAccount', $value);
    }

    /**
     * @return string
     */
    public function getCodeNo()
    {
        return $this->getParameter('CodeNo');
    }

    /**
     * @param  string  $value
     * @return ReceiveTransactionInfoRequest
     */
    public function setCodeNo($value)
    {
        return $this->setParameter('CodeNo', $value);
    }

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('transactionId', 'MerProductID', 'MerUserID', 'amount', 'Validate');

        $data = [
            'RtnCode' => $this->getRtnCode(),
            'RtnMessage' => $this->getRtnMessage(),
            'MerTradeID' => $this->getTransactionId(),
            'MerProductID' => $this->getMerProductID(),
            'MerUserID' => $this->getMerUserID(),
            'Amount' => $this->getAmount(),
            'PaymentDate' => $this->getPaymentDate(),
            'ExpireTime' => $this->getExpireTime(),
            'VatmBankCode' => $this->getVatmBankCode(),
            'VatmAccount' => $this->getVatmAccount(),
            'CodeNo' => $this->getCodeNo(),
            'Validate' => $this->getValidate(),
        ];

        if ($this->makeHash($data) !== $this->getValidate()) {
            throw new InvalidRequestException('validate fails');
        }

        return array_filter($data, static function ($value) {
            return ! empty($value);
        });
    }

    /**
     * @param  array  $data
     * @return ReceiveTransactionInfoResponse
     */
    public function sendData($data)
    {
        return $this->response = new ReceiveTransactionInfoResponse($this, $data);
    }
}
