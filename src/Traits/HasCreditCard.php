<?php

namespace Omnipay\MyCash\Traits;

trait HasCreditCard
{
    public function getUnionPay()
    {
        return $this->getParameter('UnionPay') ?: 0;
    }

    public function setUnionPay($value)
    {
        return $this->setParameter('UnionPay', $value);
    }

    public function getInstallment()
    {
        return $this->getParameter('Installment') ?: 0;
    }

    public function setInstallment($value)
    {
        return $this->setParameter('Installment', $value);
    }

}
