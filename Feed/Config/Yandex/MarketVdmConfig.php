<?php

namespace santon\Feed\Config\Yandex;

class MarketVdmConfig extends MarketMskConfig
{
    const REGION_ID   = 796;
    const REGION_ADDR = 'Владимир, Владимирская область';
    const REGION_CODE = 'vladimir';
    const URL_PARAMS  = [
        'utm_source' => 'tovary_YaMarket_vdm',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];
}
