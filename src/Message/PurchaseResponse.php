<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    public function isSuccessful(): bool
    {
        return false;
    }

    public function isRedirect(): bool
    {
        return true;
    }

    public function getRedirectUrl(): string
    {
        $url = 'https://api.mycash.asia/payment/';

        $choosePayment = $this->request->getPaymentMethod();

        if ($choosePayment === 'ATM') {
            return $url.'VirAccountPaymentGate.php';
        }

        if (in_array($choosePayment, ['CVS', 'BARCODE', 'FunPoint'], true)) {
            return $url.'StorePaymentGate.php';
        }

        return $url.'CreditPaymentGate.php';
    }

    public function getRedirectMethod(): string
    {
        return 'POST';
    }

    public function getRedirectData(): array
    {
        return $this->getData();
    }
}
