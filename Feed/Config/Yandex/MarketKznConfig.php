<?php

namespace santon\Feed\Config\Yandex;

class MarketKznConfig extends MarketMskConfig
{
    const REGION_ID   = 1283;
    const REGION_ADDR = 'Казань';
    const REGION_CODE = 'kazan';
    const URL_PARAMS  = [
        'utm_source' => 'tovary_YaMarket_kzn',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];
}
