<?php

namespace vmax\Feed\Feeds\Yandex;

use vmax\Feed\Entities\FeedCategory;
use vmax\Feed\Entities\FeedProduct;
use vmax\Feed\Exceptions\FeedEntityException;
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

    protected $defaultRegionId = 2097;
    protected $maxAdditionalImages = 9;
    protected $deliveryDaysRange = [];
    protected $deliveryRequest = ['product' => [1631099]];

    public function __construct()
    {
        $this->setDeliveryDays();
    }

    /**
     * @return string
     */
    public function getHeader(): string
    {
        return "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n" .
            "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n" .
            "<yml_catalog date=\"" . date("Y-m-d H:i:s") . "\">\n" .
            "<shop>\n";
    }

    public function getFooter(): string
    {
        return "</shop></yml_catalog>";
    }


    /**
     * @return int
     */
    public function getDefaultRegionId(): int
    {
        return $this->defaultRegionId;
    }

    /**
     * @return array
     * @throws \Exception
     */
    public function getDeliveryDays()
    {
        return $this->deliveryDaysRange;
    }

    public function setDeliveryDays($locationId = null)
    {
        $location = new Location($locationId ?: $this->getDefaultRegionId());
        $response_delivery_days = $location->getBasketDeliveryPrice(false, false, $this->deliveryRequest);

        $getDeliveryDaysRange = $response_delivery_days['calc']['deliveryProduct']['data']['SANTON_DELIVERY']['days'];

        $dateCurrent = new \DateTime(date('Y-m-d H:i:s'));
        $dateTo = new \DateTime(date('Y-m-d H:i:s', $getDeliveryDaysRange['to']));
        $this->deliveryDaysRange['diff_to'] = date_diff($dateCurrent, $dateTo)->days;
        $this->deliveryDaysRange['diff_max'] = (date_diff($dateCurrent, $dateTo)->days) + 2; //+2 дня сдвиг доставки
    }


    public function prepareProducts(array $data)
    {
        $this->data = [];
        foreach ($data as &$product) {
            $properties = unserialize($product['PARAMS']);
            $delivery = unserialize($product['DELIVERY_PRICE']);
            $defaultRegionId = $this->getDefaultRegionId();
            $deliveryPrice = $delivery[$defaultRegionId];

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
     * @throws FeedEntityException
     */
    public function prepareCategories(array $data)
    {
        $this->data = $this->collectCategoriesData($data);
    }

    private function collectCategoriesData(array $categories)
    {
        $result = [];
        foreach ($categories as $category) {
            $obCategory = new FeedCategory($category);
            /** @var  */
            if (!empty($category['CHILDREN'])) {
                /** @var array $children */
                $children = $this->collectCategoriesData($category['CHILDREN']);
                $obCategory->setChildren($children);
            }
            $result[] = $obCategory;
        }

        return $result;
    }
}
