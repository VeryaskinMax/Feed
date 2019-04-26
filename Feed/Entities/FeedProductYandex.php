<?php

namespace santon\Feed\Entities;

use santon\Feed\Interfaces\FeedEntityInterface;

class FeedProductYandex implements FeedEntityInterface
{
    const ENTITY_TYPE = 'productYandex';

    /** @var int */
    private $id;
    /** @var int */
    private $art;
    /** @var string */
    private $name;
    /** @var int */
    private $active;
    /** @var string */
    private $typePrefix;
    /** @var string */
    private $vendor;
    /** @var string */
    private $vendorCode;
    /** @var string */
    private $model;
    /** @var string */
    private $url;
    /** @var int */
    private $price;
    /** @var string */
    private $currency;
    /** @var int */
    private $feedCategoryId;
    /** @var string */
    private $picture;
    /** @var string */
    private $delivery;
    /** @var array */
    private $deliveryPrice = [];
    /** @var string */
    private $description;
    /** @var string */
    private $manufacturerWarranty;
    /** @var string */
    private $country;
    /** @var string */
    private $salesNotes;
    /** @var array */
    private $params = [];
    /** @var array */
    private $additionalImages = [];

    public function __construct(array $product)
    {
        $this->setId((int)$product['PRODUCT_ID'] ?: 0);
        $this->setName($product['NAME'] ?: '');
        $this->setArt((int)$product['ART']);
        $this->setPrice((int)$product['PRICE']);
        $this->setPicture($product['PICTURE'] ?: '');
        $this->setUrl($product['URL'] ?: '');
        $this->setVendor($product['VENDOR'] ?: '');
        $this->setVendorCode($product['VENDOR_CODE'] ?: '');
        $this->setTypePrefix($product['TYPE_PREFIX'] ?: '');
        $this->setSalesNotes($product['SALES_NOTES'] ?: '');
        $this->setActive((int)$product['ACTIVE_PRODUCT']);
        $this->setAdditionalImages($product['ADDITIONAL_IMAGES'] ?: []);
        $this->setCountry($product['COUNTRY_OF_ORIGIN'] ?: '');
        $this->setCurrency($product['CURRENCY'] ?: '');
        $this->setDelivery($product['DELIVERY'] ?: 'FALSE');
        $this->setDeliveryPrice($product['DELIVERY_PRICE'] ?: []);
        $this->setDescription($product['DESCRIPTION'] ?: '');
        $this->setFeedCategoryId((int)$product['FEED_CATEGORY_ID']);
        $this->setModel($product['MODEL'] ?: '');
        $this->setManufacturerWarranty($product['MANUFACTURER_WARRANTY'] ?: 'false');
        $this->setParams($product['PARAMS'] ?: []);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getArt(): int
    {
        return $this->art;
    }

    /**
     * @param int $art
     */
    public function setArt(int $art)
    {
        $this->art = $art;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getActive(): int
    {
        return $this->active;
    }

    /**
     * @param int $active
     */
    public function setActive(int $active)
    {
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getTypePrefix(): string
    {
        return $this->typePrefix;
    }

    /**
     * @param string $typePrefix
     */
    public function setTypePrefix(string $typePrefix)
    {
        $this->typePrefix = $typePrefix;
    }

    /**
     * @return string
     */
    public function getVendor(): string
    {
        return $this->vendor;
    }

    /**
     * @param string $vendor
     */
    public function setVendor(string $vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return string
     */
    public function getVendorCode(): string
    {
        return $this->vendorCode;
    }

    /**
     * @param string $vendorCode
     */
    public function setVendorCode(string $vendorCode)
    {
        $this->vendorCode = $vendorCode;
    }

    /**
     * @return string
     */
    public function getModel(): string
    {
        return $this->model;
    }

    /**
     * @param string $model
     */
    public function setModel(string $model)
    {
        $this->model = $model;
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency)
    {
        $this->currency = $currency;
    }

    /**
     * @return int
     */
    public function getFeedCategoryId(): int
    {
        return $this->feedCategoryId;
    }

    /**
     * @param int $feedCategoryId
     */
    public function setFeedCategoryId(int $feedCategoryId)
    {
        $this->feedCategoryId = $feedCategoryId;
    }

    /**
     * @return string
     */
    public function getPicture(): string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     */
    public function setPicture(string $picture)
    {
        $this->picture = $picture;
    }

    /**
     * @return string
     */
    public function getDelivery(): string
    {
        return $this->delivery;
    }

    /**
     * @param string $delivery
     */
    public function setDelivery(string $delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * @return array
     */
    public function getDeliveryPrice(): array
    {
        return $this->deliveryPrice;
    }

    /**
     * @param array $deliveryPrice
     */
    public function setDeliveryPrice(array $deliveryPrice)
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return true
     */
    public function getManufacturerWarranty()
    {
        return $this->manufacturerWarranty;
    }

    /**
     * @param string $manufacturerWarranty
     */
    public function setManufacturerWarranty($manufacturerWarranty)
    {
        $this->manufacturerWarranty = $manufacturerWarranty;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getSalesNotes(): string
    {
        return $this->salesNotes;
    }

    /**
     * @param string $salesNotes
     */
    public function setSalesNotes(string $salesNotes)
    {
        $this->salesNotes = $salesNotes;
    }

    /**
     * @return array
     */
    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array $params
     */
    public function setParams(array $params)
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function getAdditionalImages(): array
    {
        return $this->additionalImages;
    }

    /**
     * @param array $additionalImages
     */
    public function setAdditionalImages(array $additionalImages)
    {
        $this->additionalImages = $additionalImages;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::ENTITY_TYPE;
    }
}
