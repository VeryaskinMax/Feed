<?php

namespace vmax\Feed\Feeds\Yandex;

use vmax\Feed\Config\FeedConfig;
use vmax\Feed\Entities\FeedCategory;
use vmax\Feed\Entities\FeedProduct;
use vmax\Feed\Feeds\AbstractFeed;
use vmax\Location\Location;

class YandexMarket extends AbstractFeed
{
    const FILTERED_PARAMS = [
        'ART',
        'ACTIVE_PRODUCT',
        'TYPE_PREFIX',
        'ALWAYS_TO_ORDER',
        'DESCRIPTION',
        'POSTFIX',
        'MODEL',
        'COUNTRY',
        'WARRANTY',
        'BRAND',
    ];

    /** @var string */
    private $host;
    /** @var string */
    private $urlParams;
    /** @var int  */
    private $maxAdditionalImages = 9;
    /** @var array  */
    private $deliveryDaysRange = [];
    /** @var array  */
    private $deliveryRequest = ['product' => [1631099]];
    /** @var FeedConfig  */
    private $config;

    public function __construct(FeedConfig $config)
    {
        $this->config = $config;
        $this->host = $this->config->getHostName();
        $params = $this->config->getUrlParams();
        $this->urlParams = http_build_query($params, '', '&amp;', PHP_QUERY_RFC3986);

        $this->setDeliveryDays();
    }

    /**
     * @return array
     */
    public function getDeliveryDays(): array
    {
        return $this->deliveryDaysRange;
    }

    private function setDeliveryDays()
    {
        $location = new Location($this->config->getRegionId());
        $responseDeliveryDays = $location->getBasketDeliveryPrice(false, false, $this->deliveryRequest);

        $getDeliveryDaysRange = $responseDeliveryDays['calc']['deliveryProduct']['data']['SANTON_DELIVERY']['days'];

        $dateCurrent = new \DateTime(date('Y-m-d H:i:s'));
        $dateTo = new \DateTime(date('Y-m-d H:i:s', $getDeliveryDaysRange['to']));
        $this->deliveryDaysRange['diff_to'] = date_diff($dateCurrent, $dateTo)->days;
        $this->deliveryDaysRange['diff_max'] = (date_diff($dateCurrent, $dateTo)->days) + 2; //+2 дня сдвиг доставки
    }


    public function prepareProducts(array $data)
    {
        $this->data = [];
        $configHost = $this->config->getHostName();
        foreach ($data as &$product) {
            $properties = unserialize($product['PARAMS']);
            $delivery = unserialize($product['DELIVERY_PRICE']);
            $regionId = $this->config->getRegionId();
            $deliveryPrice = $delivery[$regionId];

            $product['URL'] .= "?" . $this->urlParams . '&amp;utm_term='.$product['ART'];
            $urlHost = parse_url($product['URL'])['host'];
            if ($urlHost !== $configHost) {
                $product['URL'] = str_replace($urlHost, $configHost, $product['URL']);
            }
            if (!empty($product['ADDITIONAL_IMAGES'])) {
                $additionalImages = [];
                if (strpos($product['ADDITIONAL_IMAGES'], ';') !== false) {
                    $arImages = explode(';', $product['ADDITIONAL_IMAGES']);
                    if(count($arImages) > $this->maxAdditionalImages){
                        for ($i = 1; $i <= $this->maxAdditionalImages; $i++){
                            $additionalImages[] = $arImages[$i];
                        }
                    }
                } else {
                    $additionalImages[] = $product['ADDITIONAL_IMAGES'];
                }

                $product['ADDITIONAL_IMAGES'] = $additionalImages;
            }

            $getDeliveryDays = $this->getDeliveryDays();
            $deliveryDays = $getDeliveryDays['diff_to'] . '-' . $getDeliveryDays['diff_max'];

            if((int)$properties['ALWAYS_TO_ORDER']['VALUE'] === 1){
                $deliveryDays = 32;
            }

            $product['PARAMS'] = array_filter($properties, [$this, 'filterParams'], ARRAY_FILTER_USE_KEY);
            $product['DELIVERY_PRICE'] = ['PRICE' => $deliveryPrice, 'DAYS' => $deliveryDays];
            $product['DESCRIPTION'] = str_replace('|', "\n", $product['DESCRIPTION']);
            $product['MANUFACTURER_WARRANTY'] = ((int)$product['MANUFACTURER_WARRANTY'] === 1) ? 'true' : 'false';
            $product['DELIVERY'] = ((int)$product['DELIVERY'] === 1) ? 'true' : 'false';

            $preparedProducts[] = $product;
        }
        unset($product);

        $filteredProducts = array_filter($data, [$this, 'filterProduct']);
        foreach ($filteredProducts as $filteredProduct) {
            $this->data[] = new FeedProduct($filteredProduct);
        }

        return $this;
    }

    /**
     * @param string $paramCode
     *
     * @return bool
     */
    private function filterParams(string $paramCode): bool
    {
        return !in_array($paramCode, self::FILTERED_PARAMS, true);
    }

    /**
     * @param array $product
     *
     * @return bool
     */
    private function filterProduct(array $product): bool
    {
        $hasError = false;

        if ($product['PARAMS']['STOCK_TYPE']['VALUE'] === 'Уценка') {
            $hasError = true;
        }
        if (!empty($product['PARAMS']['TYPE_OF_DISCOUNT']['VALUE'])) {
            $hasError = true;
        }

        return $hasError === false;
    }

    /**
     * @param array $data
     *
     */
    public function prepareCategories(array $data)
    {
        $this->data = $this->doPrepareCategoriesData($data);
    }

    /**
     * @param array $categories
     *
     * @return array
     */
    private function doPrepareCategoriesData(array $categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $obCategory = new FeedCategory($category);
            /** @var  */
            if (!empty($category['CHILDREN'])) {
                /** @var array $children */
                $children = $this->doPrepareCategoriesData($category['CHILDREN']);
                $obCategory->setChildren($children);
            }
            $result[] = $obCategory;
        }

        return $result;
    }
}
