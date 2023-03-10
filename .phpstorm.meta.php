<?php

namespace PHPSTORM_META {

    /** @noinspection PhpIllegalArrayKeyTypeInspection */
    /** @noinspection PhpUnusedLocalVariableInspection */
    $STATIC_METHOD_TYPES = [
      \Omnipay\Omnipay::create('') => [
        'MyCash' instanceof \Omnipay\MyCash\Gateway,
      ],
      \Omnipay\Common\GatewayFactory::create('') => [
        'MyCash' instanceof \Omnipay\MyCash\Gateway,
      ],
    ];
}
