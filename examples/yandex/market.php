<?php

use santon\Feed\Config\Yandex\{
    MarketMskConfig,
    MarketKrdConfig,
    MarketKznConfig,
    MarketRndConfig,
    MarketSpbConfig,
    MarketVdmConfig
};
use santon\Feed\DataCollectors\Bitrix\CategoriesCollector;
use santon\Feed\FeedFactory;
use santon\Feed\Feeds\Yandex\YandexMarket;
use santon\Feed\Generators\FeedGenerator;

$_SERVER["DOCUMENT_ROOT"] = dirname(__DIR__, 5);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
$time_start = microtime(true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
@ini_set('max_execution_time', 0);

//list of regional feeds
$marketFeeds = [
    'moscow' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export.xml',
        'config' => new MarketMskConfig(),
    ],
    'krasnodar' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export_krd.xml',
        'config' => new MarketKrdConfig(),
    ],
    'kazan' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export_kzn.xml',
        'config' => new MarketKznConfig(),
    ],
    'rostovnadonu' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export_rnd.xml',
        'config' => new MarketRndConfig(),
    ],
    'piter' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export_spb.xml',
        'config' => new MarketSpbConfig(),
    ],
    'vladimir' => [
        'outputFile' => $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/yandex/yml_export_vdm.xml',
        'config' => new MarketVdmConfig(),
    ],
];

//products filter
$filter = ['IN_FEED_K50' => 0, '>FEED_CATEGORY_ID' => 0, 'ACTIVE_PRODUCT' => 1, '>ART' => 0, '>PRICE' => 0];

foreach ($marketFeeds as $marketFeed) {
    $feedGenerator = new FeedGenerator($marketFeed['outputFile']);
    $feedCategoryCollector = new CategoriesCollector($marketFeed['config']);
    /** @var YandexMarket $feed */
    $feed = FeedFactory::getFeed(FeedFactory::FEED_YANDEX_MARKET, $marketFeed['config']);
    include __DIR__ . '/market_include.php';
}

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Yandex Market feeds was successful generated" . PHP_EOL;
echo "Generated for {$time} seconds;" . PHP_EOL;
echo "Memory used: " . (memory_get_usage(true) / 1024 / 1024) . ' mb.' . PHP_EOL;
