<?php

namespace vmax\Feed;

use vmax\Feed\Config\FeedConfig;
use vmax\Feed\Exceptions\FeedFactoryException;
use vmax\Feed\Feeds\Yandex\YandexMarket;

class FeedFactory
{
    #list of available feeds
    const FEED_YANDEX_MARKET = 'yandex_market';
    const FEED_YANDEX_ADCOME = 'yandex_adcome';
    const FEED_YANDEX_PRODUCTS_AND_PRICES = 'yandex_products_and_prices';
    const FEED_YANDEX_YML = 'yandex_yml';
    const FEED_MY_TARGET = 'my_target';
    const FEED_GMC = 'gmc';
    const FEED_RTB_HOUSE = 'rtb_house';
    const FEED_K50_VENDOR = 'k50_vendor';
    const FEED_VK = 'vk';
    const FEED_DIGINETICA = 'diginetica';
    const FEED_EXPERTSENDER = 'expertsender';

    /**
     * @param string     $feedName
     * @param FeedConfig $config

     * @throws FeedFactoryException
     */
    public static function getFeed(string $feedName, FeedConfig $config)
    {
        switch ($feedName){
            case self::FEED_YANDEX_MARKET:
                return new YandexMarket($config);
            default:
               throw new FeedFactoryException(sprintf("Feed \"%s\" not found", $feedName));
        }
    }
}
