<?php

namespace santon\Feed\Feeds\Yandex;

use santon\Feed\Config\FeedConfig;
use santon\Feed\Entities\FeedProductYandex;
use santon\Feed\Feeds\AbstractFeed;
use santon\Location\Location;

class YandexMarket extends AbstractFeed
{
    /** @var string */
    private $urlParams;
    /** @var int */
    private $maxAdditionalImages = 9;
    /** @var array */
    private $deliveryDaysRange = [];
    /** @var array */
    private $deliveryRequest = ['product' => [1631099]];

    public function __construct(FeedConfig $config)
    {
        parent::__construct($config);
        $params = $this->getConfig()->getUrlParams();
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
        $location = new Location($this->getConfig()->getRegionId());
        $responseDeliveryDays = $location->getBasketDeliveryPrice(false, false, $this->deliveryRequest);

        $getDeliveryDaysRange = $responseDeliveryDays['calc']['deliveryProduct']['data']['SANTON_DELIVERY']['days'];

        $dateCurrent = new \DateTime(date('Y-m-d H:i:s'));
        $dateTo = new \DateTime(date('Y-m-d H:i:s', $getDeliveryDaysRange['to']));
        $this->deliveryDaysRange['diff_to'] = date_diff($dateCurrent, $dateTo)->days;
        $this->deliveryDaysRange['diff_max'] = (date_diff($dateCurrent, $dateTo)->days) + 2; //+2 дня сдвиг доставки
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function prepareProducts(array $data): self
    {
        $preparedProducts = array_map([$this, 'doPrepareProducts'], $data);
        $filteredProducts = array_filter($preparedProducts, [$this, 'filterProduct']);
        $this->data = array_map(static function ($arProduct) {
            return new FeedProductYandex($arProduct);
        }, $filteredProducts);

        return $this;
    }

    /**
     * @param array $product
     *
     * @return array
     */
    private function doPrepareProducts(array $product): array
    {
        $configHost = $this->getConfig()->getHostName();
        $properties = unserialize($product['PARAMS']);
        $delivery = unserialize($product['DELIVERY_PRICE']);
        $regionId = $this->getConfig()->getRegionId();
        $deliveryPrice = $delivery[$regionId];

        $product['URL'] .= "?" . $this->urlParams . '&amp;utm_term=' . $product['ART'];
        $parsedUrl = parse_url($product['URL']);
        $urlSchemeHost = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        if ($urlSchemeHost !== $configHost) {
            $product['URL'] = str_replace($urlSchemeHost, $configHost, $product['URL']);
        }
        if (!empty($product['ADDITIONAL_IMAGES'])) {
            $additionalImages = [];
            if (strpos($product['ADDITIONAL_IMAGES'], ';') !== false) {
                $arImages = explode(';', $product['ADDITIONAL_IMAGES']);
                if (count($arImages) > $this->maxAdditionalImages) {
                    for ($i = 1; $i <= $this->maxAdditionalImages; $i++) {
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

        if ((int)$properties['ALWAYS_TO_ORDER']['VALUE'] === 1) {
            $deliveryDays = 32;
        }

        $product['PARAMS'] = array_filter($properties, [$this, 'filterParams'], ARRAY_FILTER_USE_KEY);
        $product['DELIVERY_PRICE'] = ['PRICE' => $deliveryPrice, 'DAYS' => $deliveryDays];
        $product['DESCRIPTION'] = str_replace('|', "\n", $product['DESCRIPTION']);
        $product['MANUFACTURER_WARRANTY'] = ((int)$product['MANUFACTURER_WARRANTY'] === 1) ? 'true' : 'false';
        $product['DELIVERY'] = ((int)$product['DELIVERY'] === 1) ? 'true' : 'false';

        return $product;
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
}
