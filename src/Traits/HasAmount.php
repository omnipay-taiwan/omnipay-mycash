<?php

namespace Omnipay\MyCash\Traits;

trait HasAmount
{
    public function getAmount()
    {
        return $this->getParameter('amount');
    }
}
