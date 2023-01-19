<?php

namespace Omnipay\MyCash\Tests\Message;

use Omnipay\MyCash\Message\PurchaseRequest;
use Omnipay\Tests\TestCase;

class PurchaseRequestTest extends TestCase
{
    /** @var PurchaseRequest */
    private $request;

    private $options;

    public function setUp(): void
    {
        parent::setUp();

        $this->options = [
            'MerTradeID' => '123456', // 店家交易編號(店家自行設定，不得小於 6 個字元，不得重複)
            'MerProductID' => 'Item', // 店家商品代號(店家自行設定，不得小於 4 個字元)
            'MerUserID' => 'User', // 店家消費者 ID
            'Amount' => '100', // 交易金額
            'TradeDesc' => 'ItemDesc', // 交易描述
            'ItemName' => 'ItemName', // 商品名稱
            'UnionPay' => '0', // 信用卡類別(0：一般信用卡；1：銀聯卡)
            'Installment' => '0', // 信用卡分期(未傳或非 1：不分期，1：分 3 期(分期消費金額最少 100 元))
        ];

        $this->request = new PurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $this->request->initialize(array_merge([
            'HashKey' => '5294y06JbISpM5x9', // 廠商 HashKey(由易沛提供)
            'HashIV' => 'v77hoKGq4kWxNNIS', // 廠商 HashIV(由易沛提供)
        ], $this->options));
    }

    public function testGetData(): void
    {
        $data = $this->request->getData();

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
        ], $data);
    }
}
