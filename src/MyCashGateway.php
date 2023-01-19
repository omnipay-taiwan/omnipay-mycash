<?php

namespace Omnipay\MyCash;

use Omnipay\Common\AbstractGateway;
use Omnipay\MyCash\Message\AuthorizeRequest;

/**
 * MyCash Gateway
 */
class MyCashGateway extends AbstractGateway
{
    public function getName()
    {
        return 'MyCash';
    }

    public function getDefaultParameters()
    {
        return [
            'key' => '',
            'testMode' => false,
        ];
    }

    public function getKey()
    {
        return $this->getParameter('key');
    }

    public function setKey($value)
    {
        return $this->setParameter('key', $value);
    }

    /**
     * @return Message\AuthorizeRequest
     */
    public function authorize(array $options = [])
    {
        return $this->createRequest(AuthorizeRequest::class, $options);
    }
}
