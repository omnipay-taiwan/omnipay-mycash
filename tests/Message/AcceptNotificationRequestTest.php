<?php

namespace Omnipay\MyCash\Tests\Message;

use Omnipay\Common\Exception\InvalidRequestException;
use Omnipay\Common\Message\NotificationInterface;
use Omnipay\MyCash\Message\AcceptNotificationRequest;
use Omnipay\MyCash\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class AcceptNotificationRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'FEFRGFEFWEF', // 廠商 HashKey(由易沛提供)
        'HashIV' => 'v77hoKGq4kWxNNIS', // 廠商 HashIV(由易沛提供)
        'ValidateKey' => 'ASDWDWDF',
    ];

    public function testValidateFails(): void
    {
        $this->expectException(InvalidRequestException::class);

        $options = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'Auth_code' => '12345',
            'CardNumber' => '4311-2222-2222-2222',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba1',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        $request->send();
    }

    public function testCreditCardAcceptNotificationRequest(): void
    {
        $options = [
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

        $this->getHttpRequest()->request->add($options);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('OK', $request->getReply());
        self::assertEquals('20151202001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
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
        ], $request->getData());
    }

    public function testATMAcceptNotificationRequest(): void
    {
        $options = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ATMNo' => '35123479668',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('OK', $request->getReply());
        self::assertEquals('20151202001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'ATMNo' => '35123479668',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ], $request->getData());
    }

    public function testCVSAcceptNotificationRequest(): void
    {
        $options = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'StoreName' => 'IBON',
            'StoreID' => '1234',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('OK', $request->getReply());
        self::assertEquals('20151202001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'StoreName' => 'IBON',
            'StoreID' => '1234',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ], $request->getData());
    }

    public function testFunPointAcceptNotificationRequest(): void
    {
        $options = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new AcceptNotificationRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);

        self::assertEquals('成功', $request->getMessage());
        self::assertEquals('OK', $request->getReply());
        self::assertEquals('20151202001', $request->getTransactionId());
        self::assertEquals(NotificationInterface::STATUS_COMPLETED, $request->getTransactionStatus());
        self::assertEquals([
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => 'e6d2412d68c714f9e6c1185d9e6698ba',
        ], $request->getData());
    }
}
