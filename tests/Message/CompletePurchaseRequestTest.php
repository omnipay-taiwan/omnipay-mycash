<?php

namespace Omnipay\MyCash\Tests\Message;

use Omnipay\Common\Exception\InvalidResponseException;
use Omnipay\MyCash\Message\CompletePurchaseRequest;
use Omnipay\Tests\TestCase;

class CompletePurchaseRequestTest extends TestCase
{
    private $initialize = [
        'HashKey' => 'FEFRGFEFWEF', // 廠商 HashKey(由易沛提供)
        'HashIV' => 'v77hoKGq4kWxNNIS', // 廠商 HashIV(由易沛提供)
        'ValidateKey' => 'ASDWDWDF',
    ];

    public function testValidateFails(): void
    {
        $this->expectException(InvalidResponseException::class);
        $this->expectExceptionMessage('Incorrect hash');

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

    public function testValidateSuccessful(): void
    {
        $options = [
            'RtnCode' => '1',
            'RtnMessage' => '成功',
            'MerTradeID' => '20151202001',
            'MerProductID' => 'sj6511',
            'MerUserID' => 'Karl01',
            'Amount' => '30.00',
            'Auth_code' => '12345',
            'CardNumber' => '4311-2222-2222-2222',
            'PaymentDate' => '2016-05-06 16:41:37',
            'Validate' => '216f3a2f5b3665b0c5c77860d3c18692',
        ];

        $this->getHttpRequest()->request->add($options);
        $request = new CompletePurchaseRequest($this->getHttpClient(), $this->getHttpRequest());
        $request->initialize($this->initialize);
        $response = $request->send();

        self::assertTrue($response->isSuccessful());
    }
}
