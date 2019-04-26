<?php

namespace santon\Feed;

use santon\Feed\Config\FeedConfig;
use santon\Feed\Exceptions\FeedFactoryException;
use santon\Feed\Feeds\AbstractFeed;
use santon\Feed\Feeds\Google\GoogleMerchant;
use santon\Feed\Feeds\Yandex\YandexMarket;

class FeedFactory
{
    #list of available feeds
    const FEED_YANDEX_MARKET = 'yandex_market';
    const FEED_GOOGLE_MERCHANT = 'gmc';

    /**
     * @param string     $feedName
     * @param FeedConfig $config
     *
     * @return AbstractFeed
     * @throws FeedFactoryException
     */
    public static function getFeed(string $feedName, FeedConfig $config = null)
    {
        switch ($feedName) {
            case self::FEED_YANDEX_MARKET:
                return new YandexMarket($config);
            case self::FEED_GOOGLE_MERCHANT:
                return new GoogleMerchant($config);
            default:
                throw new FeedFactoryException(sprintf("Feed \"%s\" not found", $feedName));
        }
    }
}
