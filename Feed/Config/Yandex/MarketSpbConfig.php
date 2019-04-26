<?php

namespace santon\Feed\Config\Yandex;

class MarketSpbConfig extends MarketMskConfig
{
    const REGION_ID   = 2287;
    const REGION_ADDR = 'Санкт-Петербург';
    const REGION_CODE = 'piter';
    const URL_PARAMS  = [
        'utm_source' => 'tovary_YaMarket_spb',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];
}
