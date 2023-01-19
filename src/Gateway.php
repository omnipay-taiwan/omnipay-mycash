<?php

namespace Omnipay\MyCash;

use Omnipay\Common\AbstractGateway;
use Omnipay\MyCash\Message\PurchaseRequest;
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
        ];
    }

    public function purchase(array $options = [])
    {
        return $this->createRequest(PurchaseRequest::class, $options);
    }
}
