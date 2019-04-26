<?php

namespace santon\Feed\Config\Yandex;

class MarketRndConfig extends MarketMskConfig
{
    const REGION_ID   = 1235;
    const REGION_ADDR = 'Ростов-на-Дону, Ростовская область';
    const REGION_CODE = 'rostovnadonu';
    const URL_PARAMS  = [
        'utm_source' => 'tovary_YaMarket_rnd',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];
}
