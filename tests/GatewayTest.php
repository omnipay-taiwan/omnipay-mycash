<?php

namespace Omnipay\MyCash\Tests;

use Omnipay\Common\Message\NotificationInterface;
use Omnipay\MyCash\Gateway;
use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var Gateway */
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new Gateway($this->getHttpClient(), $this->getHttpRequest());
        $this->gateway->initialize([
            'HashKey' => 'FEFRGFEFWEF',
            'HashIV' => 'v77hoKGq4kWxNNIS',
            'ValidateKey' => 'ASDWDWDF',
        ]);
    }

    public function testPurchase(): void
    {
        $response = $this->gateway->purchase([
            'transactionId' => '20151202001', // 店家交易編號(店家自行設定，不得小於 6 個字元，不得重複)
            'amount' => '30', // 交易金額
            'description' => 'ItemDesc', // 交易描述
            'MerProductID' => 'sj6511', // 店家商品代號(店家自行設定，不得小於 4 個字元)
            'MerUserID' => 'Karl01', // 店家消費者 ID
            'ItemName' => 'ItemName', // 商品名稱
            'UnionPay' => '0', // 信用卡類別(0：一般信用卡；1：銀聯卡)
            'Installment' => '0', // 信用卡分期(未傳或非 1：不分期，1：分 3 期(分期消費金額最少 100 元))
        ])->send();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('https://api.mycash.asia/payment/CreditPaymentGate.php', $response->getRedirectUrl());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals([
            'HashKey' => 'FEFRGFEFWEF',
            'HashIV' => 'v77hoKGq4kWxNNIS',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'TradeDesc' => 'ItemDesc',
            'ItemName' => 'ItemName',
            'UnionPay' => '0',
            'Installment' => '0',
        ], $response->getRedirectData());
    }

    public function testCompletePurchase(): void
    {
        $this->getHttpRequest()->request->add([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'Auth_code' => '12345',
            'CardNumber' => '4311-2222-2222-2222',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ]);
        $response = $this->gateway->completePurchase()->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('20151202001', $response->getTransactionId());
        self::assertEquals([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'Auth_code' => '12345',
            'CardNumber' => '4311-2222-2222-2222',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ], $response->getData());
    }

    public function testAcceptNotification(): void
    {
        $data = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'Auth_code' => '12345',
            'CardNumber' => '4311-2222-2222-2222',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ];

        $this->getHttpRequest()->request->add($data);
        $request = $this->gateway->acceptNotification([]);

        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('20151202001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals($data, $request->getData());
    }

    public function testReceiveTransactionInfo(): void
    {
        $this->getHttpRequest()->request->add([
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
        ]);
        $response = $this->gateway->completePurchase()->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('20151202001', $response->getTransactionId());
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

    public function testFetchTransaction(): void
    {
        $this->getMockClient()->addResponse($this->getMockHttpResponse('FetchTransaction.txt'));

        $response = $this->gateway->fetchTransaction(['MerTradeID' => '20151202001'])->send();

        self::assertTrue($response->isSuccessful());
        self::assertEquals('成功', $response->getMessage());
        self::assertEquals('747C7FC3B56E4EE4B37A', $response->getTransactionId());
        self::assertEquals([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '747C7FC3B56E4EE4B37A',
            'MerProductID' => 'sj6511',
            'Amount' => '1000',
            'PaymentDate' => '2016-05-06 16:41:37',
            'TransactionDate' => '2016-05-06 16:41:37',
        ], $response->getData());
    }
}
