<?php

namespace Omnipay\MyCash\Tests;

use Omnipay\MyCash\Hasher;
use PHPUnit\Framework\TestCase;

class HasherTest extends TestCase
{
    public function testMakeHash()
    {
        $validateKey = 'ASDWDWDF';
        $hashKey = 'FEFRGFEFWEF';

        $data = [
            'RtnCode' => '1',
            'MerTradeID' => '20151202001',
            'MerUserID' => 'Karl01',
            'Amount' => '30.00',
        ];

        $example = [
            'ValidateKey' => $validateKey,
            'HashKey' => $hashKey,
            'RtnCode' => $data['RtnCode'],
            'TradeID' => $data['MerTradeID'],
            'UserID' => $data['MerUserID'],
            'Money' => $data['Amount'],
        ];

        $hasher = new Hasher($hashKey, $validateKey);
        $actual = $hasher->make([
            'RtnCode' => $data['RtnCode'],
            'TradeID' => $data['MerTradeID'],
            'UserID' => $data['MerUserID'],
            'Money' => $data['Amount'],
        ]);

        self::assertEquals(md5(http_build_query($example)), $actual);
    }
}
