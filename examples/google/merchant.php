<?php

use santon\Feed\Config\Google\MerchantConfig;
use santon\Feed\DataBuilders\Providers\XmlBuilderProvider;
use santon\Feed\DataBuilders\Xml\GoogleMerchantXmlBuilder;
use santon\Feed\DataCollectors\Bitrix\CategoriesCollector;
use santon\Feed\DataCollectors\Bitrix\ProductsCollector;
use santon\Feed\Entities\FeedCategory;
use santon\Feed\Entities\FeedProductGoogle;
use santon\Feed\FeedFactory;
use santon\Feed\Feeds\Google\GoogleMerchant;
use santon\Feed\Generators\FeedGenerator;
use santon\Models\MarketingFeedProductsTable;

$_SERVER["DOCUMENT_ROOT"] = dirname(__DIR__, 5);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
$time_start = microtime(true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
@ini_set('max_execution_time', 0);

$config = new MerchantConfig();
$filter = [
    'IN_FEED_K50' => 0,
    '>FEED_CATEGORY_ID' => 0,
    '!FEED_CATEGORY_ID' => 121,
    'ACTIVE_PRODUCT' => 1,
    '!VENDOR' => false,
    '>ART' => 0,
];
$outputFile = $_SERVER['DOCUMENT_ROOT'] . '/xml_feed/google/google_merchants.xml';

$feedGenerator = new FeedGenerator($outputFile);
$feedCategoryCollector = new CategoriesCollector($config);

/** @var GoogleMerchant $feed */
$feed = FeedFactory::getFeed(FeedFactory::FEED_GOOGLE_MERCHANT, $config);

$feedBuilder = new GoogleMerchantXmlBuilder(new XmlBuilderProvider());
$databaseTableModel = new MarketingFeedProductsTable();
$productsCollector = new ProductsCollector($databaseTableModel);
//write feed header to file
$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n" .
    "<rss version=\"2.0\" xmlns:g=\"http://base.google.com/ns/1.0\">\n" .
    "<channel>\n";
$feedGenerator->writeToFile($xmlHeader);

//work with categories
$feed->switchEntity(FeedCategory::ENTITY_TYPE);
$feedGenerator->writeToFile("<categories>\n");
$arCategories = $feedCategoryCollector->getCollection();
$feed->prepareCategories($arCategories);
$xmlString = $feedBuilder->build($feed)->getResult();
$feedGenerator->writeToFile($xmlString);
$feedGenerator->writeToFile("</categories>\n");

//work with products
$feed->switchEntity(FeedProductGoogle::ENTITY_TYPE);
$productsCollector->getQueryBuilder()->setFilter($filter);
$productsCount = $productsCollector->getCount();
$iterationSteps = $productsCollector->getIterationSteps($productsCount);
$productsLimit = $productsCollector->getProductsPerStep();

for ($currentStep = 1; $currentStep <= $iterationSteps; $currentStep++) {
    $offset = ($currentStep * $iterationSteps) - $iterationSteps;

    $productsCollector->getQueryBuilder()->setOffset($offset);
    $productsCollector->getQueryBuilder()->setLimit($productsLimit);

    $arProducts = $productsCollector->getCollection();
    $feed->prepareProducts($arProducts);

    $xmlString = $feedBuilder->build($feed)->getResult();
    $feedGenerator->writeToFile($xmlString);
}

//write feed footer
$xmlFooter = "</channel></rss>";
$feedGenerator->writeToFile($xmlFooter);

//finish up. make backup, delete tmp file
$feedGenerator->finish();

$time_end = microtime(true);
$time = $time_end - $time_start;
echo "Google Merchant feed was successful generated" . PHP_EOL;
echo "Generated for {$time} seconds;" . PHP_EOL;
echo "Memory used: " . (memory_get_usage(true) / 1024 / 1024) . ' mb.' . PHP_EOL;
