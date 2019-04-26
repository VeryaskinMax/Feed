<?php

namespace santon\Feed\Entities;

use santon\Feed\Interfaces\FeedEntityInterface;

class FeedProductGoogle implements FeedEntityInterface
{
    const ENTITY_TYPE = 'productGoogle';

    /** @var int */
    private $id;
    /** @var int */
    private $art;
    /** @var string */
    private $title;
    /** @var string */
    private $link;
    /** @var string */
    private $description;
    /** @var string */
    private $productType;
    /** @var string */
    private $brand;
    /** @var string */
    private $availability;
    /** @var int */
    private $googleProductCategory;
    /** @var string */
    private $customLabel_0;
    /** @var string */
    private $customLabel_1;
    /** @var string */
    private $image;
    /** @var string */
    private $currency;
    /** @var int */
    private $price;
    /** @var string */
    private $adwordsGrouping;
    /** @var string */
    private $condition;
    /** @var string */
    private $gtin;
    /** @var string */
    private $mpn;
    /** @var string */
    private $identifierExists;
    /** @var array */
    private $additionalImages;

    public function __construct(array $product)
    {
        $this->setPrice((int)$product['PRICE']);
        $this->setMpn($product['MPN'] ?: '');
        $this->setGtin($product['GTIN'] ?: '');
        $this->setGoogleProductCategory($product['GOOGLE_PRODUCT_CATEGORY'] ?: '');
        $this->setDescription($product['DESCRIPTION'] ?: '');
        $this->setCurrency($product['CURRENCY'] ?: '');
        $this->setArt((int)$product['ART']);
        $this->setAdwordsGrouping($product['ADWORDS_GROUPING'] ?: '');
        $this->setAdditionalImages($product['ADDITIONAL_IMAGES'] ?: []);
        $this->setId((int)$product['PRODUCT_ID']);
        $this->setAvailability($product['AVAILABILITY'] ?: 'in stock');
        $this->setBrand($product['VENDOR'] ?: '');
        $this->setCondition($product['CONDITION'] ?: 'new');
        $this->setCustomLabel0($product['CUSTOM_LABEL_0'] ?: '');
        $this->setCustomLabel1($product['CUSTOM_LABEL_1'] ?: '');
        $this->setIdentifierExists($product['IDENTIFIER'] ?: 'no');
        $this->setImage($product['PICTURE'] ?: '');
        $this->setLink($product['URL'] ?: '');
        $this->setProductType($product['PRODUCT_TYPE'] ?: '');
        $this->setTitle($product['NAME'] ?: '');
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
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
     * @return string
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     */
    public function setProductType(string $productType)
    {
        $this->productType = $productType;
    }

    /**
     * @return string
     */
    public function getBrand(): string
    {
        return $this->brand;
    }

    /**
     * @param string $brand
     */
    public function setBrand(string $brand)
    {
        $this->brand = $brand;
    }

    /**
     * @return string
     */
    public function getAvailability(): string
    {
        return $this->availability;
    }

    /**
     * @param string $availability
     */
    public function setAvailability(string $availability)
    {
        $this->availability = $availability;
    }

    /**
     * @return int
     */
    public function getGoogleProductCategory(): int
    {
        return $this->googleProductCategory;
    }

    /**
     * @param int $googleProductCategory
     */
    public function setGoogleProductCategory(int $googleProductCategory)
    {
        $this->googleProductCategory = $googleProductCategory;
    }

    /**
     * @return string
     */
    public function getCustomLabel0(): string
    {
        return $this->customLabel_0;
    }

    /**
     * @param string $customLabel_0
     */
    public function setCustomLabel0(string $customLabel_0)
    {
        $this->customLabel_0 = $customLabel_0;
    }

    /**
     * @return string
     */
    public function getCustomLabel1(): string
    {
        return $this->customLabel_1;
    }

    /**
     * @param string $customLabel_1
     */
    public function setCustomLabel1(string $customLabel_1)
    {
        $this->customLabel_1 = $customLabel_1;
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage(string $image)
    {
        $this->image = $image;
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
    public function getAdwordsGrouping(): string
    {
        return $this->adwordsGrouping;
    }

    /**
     * @param string $adwordsGrouping
     */
    public function setAdwordsGrouping(string $adwordsGrouping)
    {
        $this->adwordsGrouping = $adwordsGrouping;
    }

    /**
     * @return string
     */
    public function getCondition(): string
    {
        return $this->condition;
    }

    /**
     * @param string $condition
     */
    public function setCondition(string $condition)
    {
        $this->condition = $condition;
    }

    /**
     * @return string
     */
    public function getGtin(): string
    {
        return $this->gtin;
    }

    /**
     * @param string $gtin
     */
    public function setGtin(string $gtin)
    {
        $this->gtin = $gtin;
    }

    /**
     * @return string
     */
    public function getMpn(): string
    {
        return $this->mpn;
    }

    /**
     * @param string $mpn
     */
    public function setMpn(string $mpn)
    {
        $this->mpn = $mpn;
    }

    /**
     * @return string
     */
    public function getIdentifierExists(): string
    {
        return $this->identifierExists;
    }

    /**
     * @param string $identifierExists
     */
    public function setIdentifierExists(string $identifierExists)
    {
        $this->identifierExists = $identifierExists;
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
