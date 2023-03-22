<?php

namespace Omnipay\MyCash\Tests;

use Omnipay\MyCash\Hasher;
use PHPUnit\Framework\TestCase;

class HasherTest extends TestCase
{
    public function testMakeHash()
    {
        $hashKey = 'FEFRGFEFWEF';
        $validateKey = 'ASDWDWDF';
        $rtnCode = '1';
        $tradeId = '20151202001';
        $userId = 'Karl01';
        $money = '30';

        $hasher = new Hasher($hashKey, $validateKey);

        $expected = md5("ValidateKey=$validateKey&HashKey=$hashKey&RtnCode=$rtnCode&TradeID=$tradeId&UserID=$userId&Money=$money");
        $actual = $hasher->make(['RtnCode' => $rtnCode, 'TradeID' => $tradeId, 'UserID' => $userId, 'Money' => $money]);

        self::assertEquals($expected, $actual);
    }
}
