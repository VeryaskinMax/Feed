<?php

namespace vmax\Feed\Config\Yandex;

use vmax\Feed\Config\FeedConfig;

class MarketMskConfig extends FeedConfig
{
    /** @var int  */
    private $regionId = 2097;
    /** @var string  */
    private $regionAddr = 'Москва, Московская область';
    /** @var string  */
    private $regionCode = 'moscow';
    /** @var array  */
    private $urlParams = [
        'utm_source' => 'tovary_YaMarket',
        'utm_medium' => 'cp',
        'utm_campaign' => 'PriceAgr'
    ];

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return $this->regionId;
    }

    /**
     * @return string
     */
    public function getRegionAddr(): string
    {
        return $this->regionAddr;
    }

    /**
     * @return string
     */
    public function getRegionCode(): string
    {
        return $this->regionCode;
    }

    /**
     * @return array
     */
    public function getUrlParams(): array
    {
        return $this->urlParams;
    }
}
