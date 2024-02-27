<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasAmount;
use Omnipay\MyCash\Traits\HasCreditCard;
use Omnipay\MyCash\Traits\HasCVS;
use Omnipay\MyCash\Traits\HasDefaults;
use Omnipay\MyCash\Traits\HasMyCash;

class PurchaseRequest extends AbstractRequest
{
    use HasAmount;
    use HasCreditCard;
    use HasCVS;
    use HasDefaults;
    use HasMyCash;

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        $lookup = [
            'atm' => 'ATM',
            'cvs' => 'CVS',
            'barcode' => 'BARCODE',
            'funpoint' => 'FunPoint',
        ];
        $paymentMethod = strtolower(parent::getPaymentMethod() ?? '');

        return array_key_exists($paymentMethod, $lookup) ? $lookup[$paymentMethod] : 'CreditCard';
    }

    /**
     * @return string
     */
    public function getChoosePayment()
    {
        return $this->getPaymentMethod();
    }

    /**
     * @param  string  $value
     * @return PurchaseRequest
     */
    public function setChoosePayment($value)
    {
        return $this->setPaymentMethod($value);
    }

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate(
            'HashKey',
            'HashIV',
            'transactionId',
            'amount',
            'description',
            'MerProductID',
            'MerUserID',
            'ItemName'
        );

        $common = [
            'HashKey' => $this->getHashKey(),
            'HashIV' => $this->getHashIV(),
            'MerTradeID' => $this->getTransactionId(),
            'MerProductID' => $this->getMerProductID(),
            'MerUserID' => $this->getMerUserID(),
        ];

        $paymentMethod = $this->getPaymentMethod();

        if ($paymentMethod === 'ATM') {
            return array_merge($common, [
                'Amount' => $this->getAmount(),
                'TradeDesc' => $this->getDescription(),
                'ItemName' => $this->getItemName(),
            ]);
        }

        if (in_array($paymentMethod, ['CVS', 'BARCODE', 'FunPoint'], true)) {
            return array_filter(array_merge($common, [
                'ChoosePayment' => $this->getPaymentMethod(),
                'ChooseStoreID' => $this->getChooseStoreID(),
                'Amount' => $this->getAmount(),
                'TradeDesc' => $this->getDescription(),
                'ItemName' => $this->getItemName(),
            ]), static function ($value) {
                return ! empty($value);
            });
        }

        return array_merge($common, [
            'Amount' => $this->getAmount(),
            'TradeDesc' => $this->getDescription(),
            'ItemName' => $this->getItemName(),
            'UnionPay' => $this->getUnionPay(),
            'Installment' => $this->getInstallment(),
        ]);
    }

    /**
     * @param  array  $data
     */
    public function sendData($data): PurchaseResponse
    {
        return $this->response = new PurchaseResponse($this, $data);
    }
}
