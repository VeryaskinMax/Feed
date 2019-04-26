<?php

namespace santon\Feed\Config\Yandex;

class MarketKrdConfig extends MarketMskConfig
{
    const REGION_ID   = 1427;
    const REGION_ADDR = 'Краснодар';
    const REGION_CODE = 'krasnodar';
    const URL_PARAMS  = [
        'utm_source' => 'tovary_YaMarket_krd',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];
}
