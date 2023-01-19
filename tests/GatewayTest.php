<?php

namespace Omnipay\Skeleton;

use Omnipay\Tests\GatewayTestCase;

class GatewayTest extends GatewayTestCase
{
    /** @var SkeletonGateway */
    protected $gateway;

    public function setUp(): void
    {
        parent::setUp();

        $this->gateway = new SkeletonGateway($this->getHttpClient(), $this->getHttpRequest());

        $this->options = [
            'amount' => '10.00',
            'card' => $this->getValidCard(),
        ];
    }

    public function testAuthorize()
    {
        $this->setMockHttpResponse('AuthorizeSuccess.txt');

        $response = $this->gateway->authorize($this->options)->send();

        $this->assertTrue($response->isSuccessful());
        $this->assertEquals('1234', $response->getTransactionReference());
        $this->assertNull($response->getMessage());
    }
}
