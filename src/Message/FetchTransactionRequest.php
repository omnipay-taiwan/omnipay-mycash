<?php

namespace Omnipay\MyCash\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\AbstractRequest;
use Omnipay\MyCash\Traits\HasMyCash;

class FetchTransactionRequest extends AbstractRequest
{
    use HasMyCash;

    /**
     * @return array
     *
     * @throws InvalidRequestException
     */
    public function getData()
    {
        $this->validate('HashKey', 'HashIV', 'transactionId');

        return [
            'HashKey' => $this->getHashKey(),
            'HashIV' => $this->getHashIV(),
            'MerTradeID' => $this->getTransactionId(),
        ];
    }

    /**
     * @param  array  $data
     * @return CompletePurchaseResponse
     */
    public function sendData($data)
    {
        $response = $this->httpClient->request('POST', 'https://api.mycash.asia/CheckLedger.php', $data);

        return $this->response = new CompletePurchaseResponse($this, json_decode((string) $response->getBody(), true));
    }
}
