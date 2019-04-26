<?php

use santon\Feed\DataBuilders\Providers\XmlBuilderProvider;
use santon\Feed\DataBuilders\Xml\YandexMarketXmlBuilder;
use santon\Feed\DataCollectors\Bitrix\ProductsCollector;
use santon\Feed\Entities\FeedCategory;
use santon\Feed\Entities\FeedProductYandex;
use santon\Models\MarketingFeedProductsTable;

$feedBuilder = new YandexMarketXmlBuilder(new XmlBuilderProvider());
$databaseTableModel = new MarketingFeedProductsTable();
$productsCollector = new ProductsCollector($databaseTableModel);

//write feed header to file
$xmlHeader = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n" .
    "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n" .
    "<yml_catalog date=\"" . date("Y-m-d H:i:s") . "\">\n" .
    "<shop>\n";
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
$feed->switchEntity(FeedProductYandex::ENTITY_TYPE);
$productsCollector->getQueryBuilder()->setFilter($filter);
$productsCount = $productsCollector->getCount();
$iterationSteps = $productsCollector->getIterationSteps($productsCount);
$productsLimit = $productsCollector->getProductsPerStep();
$feedGenerator->writeToFile("<offers>\n");
for ($currentStep = 1; $currentStep <= $iterationSteps; $currentStep++) {
    //calculate offset
    $offset = ($currentStep * $iterationSteps) - $iterationSteps;

    $productsCollector->getQueryBuilder()->setOffset($offset);
    $productsCollector->getQueryBuilder()->setLimit($productsLimit);
    //get products array from products data collector
    $arProducts = $productsCollector->getCollection();
    //prepare and filter products
    $feed->prepareProducts($arProducts);
    //build xml node
    $xmlString = $feedBuilder->build($feed)->getResult();
    //write xml node to file
    $feedGenerator->writeToFile($xmlString);
}
$feedGenerator->writeToFile("</offers>\n");

//write feed footer
$xmlFooter = "</shop></yml_catalog>";
$feedGenerator->writeToFile($xmlFooter);

//finish up. make backup, delete tmp file
$feedGenerator->finish();
