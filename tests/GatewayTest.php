<?php

namespace Omnipay\MyCash\Tests;

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
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS',
        ]);
    }

    public function testPurchase(): void
    {
        $response = $this->gateway->purchase([
            'transactionId' => '123456', // 店家交易編號(店家自行設定，不得小於 6 個字元，不得重複)
            'amount' => '100', // 交易金額
            'description' => 'ItemDesc', // 交易描述
            'MerProductID' => 'Item', // 店家商品代號(店家自行設定，不得小於 4 個字元)
            'MerUserID' => 'User', // 店家消費者 ID
            'ItemName' => 'ItemName', // 商品名稱
            'UnionPay' => '0', // 信用卡類別(0：一般信用卡；1：銀聯卡)
            'Installment' => '0', // 信用卡分期(未傳或非 1：不分期，1：分 3 期(分期消費金額最少 100 元))
        ])->send();

        self::assertFalse($response->isSuccessful());
        self::assertTrue($response->isRedirect());
        self::assertEquals('https://api.mycash.asia/payment/CreditPaymentGate.php', $response->getRedirectUrl());
        self::assertEquals('POST', $response->getRedirectMethod());
        self::assertEquals([
            'HashKey' => '5294y06JbISpM5x9',
            'HashIV' => 'v77hoKGq4kWxNNIS',
            'MerTradeID' => '123456',
            'MerProductID' => 'Item',
            'MerUserID' => 'User',
            'Amount' => '100',
            'TradeDesc' => 'ItemDesc',
            'ItemName' => 'ItemName',
            'UnionPay' => '0',
            'Installment' => '0',
        ], $response->getRedirectData());
    }
}
