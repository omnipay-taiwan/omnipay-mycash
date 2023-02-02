<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RedirectResponseInterface;

class PurchaseResponse extends AbstractResponse implements RedirectResponseInterface
{
    /**
     * @return bool
     */
    public function isSuccessful()
    {
        return false;
    }

    /**
     * @return bool
     */
    public function isRedirect()
    {
        return true;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
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

    /**
     * @return string
     */
    public function getRedirectMethod()
    {
        return 'POST';
    }

    /**
     * @return array
     */
    public function getRedirectData()
    {
        return $this->getData();
    }
}
