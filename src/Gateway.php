<?php

namespace Omnipay\MyCash;

use Omnipay\Common\AbstractGateway;
use Omnipay\MyCash\Message\AcceptNotificationRequest;
use Omnipay\MyCash\Message\CompletePurchaseRequest;
use Omnipay\MyCash\Message\FetchTransactionRequest;
use Omnipay\MyCash\Message\PurchaseRequest;
use Omnipay\MyCash\Message\GetPaymentInfoRequest;
use Omnipay\MyCash\Traits\HasMyCash;

/**
 * MyCash Gateway
 */
class Gateway extends AbstractGateway
{
    use HasMyCash;

    public function getName(): string
    {
        return 'MyCash';
    }

    public function getDefaultParameters(): array
    {
        return [
            'HashKey' => '',
            'HashIV' => '',
            'ValidateKey' => '',
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }

    public function completePurchase(array $options = [])
    {
        if ($this->httpRequest->request->get('RtnCode') === '5') {
            return $this->getPaymentInfo($options);
        }

        return $this->createRequest(CompletePurchaseRequest::class, $options);
    }

    public function acceptNotification(array $options = [])
    {
        if ($this->httpRequest->request->get('RtnCode') === '5') {
            return $this->getPaymentInfo($options);
        }

        return $this->createRequest(AcceptNotificationRequest::class, $options);
    }

    public function getPaymentInfo(array $options = [])
    {
        return $this->createRequest(GetPaymentInfoRequest::class, $options);
    }

    public function fetchTransaction(array $options = [])
    {
        return $this->createRequest(FetchTransactionRequest::class, $options);
    }
}
