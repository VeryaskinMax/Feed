<?php

namespace santon\Feed\Config\Yandex;

use santon\Feed\Config\FeedConfig;

class MarketMskConfig extends FeedConfig
{
    const REGION_ID = 2097;
    const REGION_ADDR = 'Москва, Московская область';
    const REGION_CODE = 'moscow';
    const URL_PARAMS = [
        'utm_source' => 'tovary_YaMarket',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr',
    ];

    /**
     * @return string
     */
    public function getRegionAddr(): string
    {
        return static::REGION_ADDR;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return static::REGION_CODE;
    }

    /**
     * @return array
     */
    public function getUrlParams(): array
    {
        return static::URL_PARAMS;
    }
}
