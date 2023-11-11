<?php

namespace Omnipay\MyCash\Tests\Message;

use Omnipay\MyCash\Message\ReceiveTransactionInfoRequest;
use Omnipay\Tests\TestCase;

class ReceiveTransactionInfoRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'FEFRGFEFWEF', // 廠商 HashKey(由易沛提供)
        'HashIV' => 'v77hoKGq4kWxNNIS', // 廠商 HashIV(由易沛提供)
        'ValidateKey' => 'ASDWDWDF',
    ];

    public function testATMReceiveTransactionInfoRequest(): void
    {
        $options = [
            'RtnCode' => '5',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ExpireTime' => '2016-05-08 16:41:37',
            'VatmBankCode' => '123',
            'VatmAccount' => '12345678',
            'Validate' => '55aab2d7bec68a3a05183e3764ad4e3a',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new ReceiveTransactionInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        $response = $request->send();

        self::assertEquals([
            'RtnCode' => '5',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ExpireTime' => '2016-05-08 16:41:37',
            'VatmBankCode' => '123',
            'VatmAccount' => '12345678',
            'Validate' => '55aab2d7bec68a3a05183e3764ad4e3a',
        ], $response->getData());
    }

    public function testCVSReceiveTransactionInfoRequest(): void
    {
        $options = [
            'RtnCode' => '5',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ExpireTime' => '2016-05-08 16:41:37',
            'CodeNo' => '987654321',
            'Validate' => '55aab2d7bec68a3a05183e3764ad4e3a',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new ReceiveTransactionInfoRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        $response = $request->send();

        self::assertEquals([
            'RtnCode' => '5',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ExpireTime' => '2016-05-08 16:41:37',
            'CodeNo' => '987654321',
            'Validate' => '55aab2d7bec68a3a05183e3764ad4e3a',
        ], $response->getData());
    }
}
