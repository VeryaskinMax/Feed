<?php

namespace santon\Feed\DataBuilders\Xml;

use santon\Feed\Entities\FeedCategory;
use santon\Feed\Entities\FeedProductYandex;
use santon\Feed\Exceptions\FeedEntityException;
use santon\Feed\Exceptions\FeedXmlBuilderException;
use santon\Feed\Interfaces\DataBuilderInterface;
use santon\Feed\Interfaces\FeedInterface;
use santon\Feed\Interfaces\XmlBuilderProviderInterface;

class YandexMarketXmlBuilder implements DataBuilderInterface
{
    const BUILD_TYPE_PRODUCT = 'productYandex';
    const BUILD_TYPE_CATEGORY = 'category';

    /** @var XmlBuilderProviderInterface */
    private $builder;
    /** @var string */
    private $result;

    public function __construct(XmlBuilderProviderInterface $builderProvider)
    {
        $this->builder = $builderProvider;
    }

    /**
     * @param FeedInterface $feed
     *
     * @return $this
     * @throws FeedEntityException
     * @throws FeedXmlBuilderException
     */
    public function build(FeedInterface $feed): self
    {
        $arFeedData = $feed->getData();

        if (!$arFeedData) {
            throw new FeedXmlBuilderException('Nothing to build, data is empty');
        }

        $entityType = $feed->getEntityType();

        switch ($entityType) {
            case self::BUILD_TYPE_PRODUCT:
                $this->buildProducts($arFeedData);
                break;
            case self::BUILD_TYPE_CATEGORY:
                $this->buildCategories($arFeedData);
                break;
            default:
                throw new FeedEntityException(sprintf("Entity \"%s\" not found", $entityType));
        }

        return $this;
    }

    /**
     * @param array $products
     */
    private function buildProducts(array $products)
    {
        /** @var FeedProductYandex $product */
        foreach ($products as $product) {
            $art = $product->getArt();
            $this->builder->newTag('offer', 'offer_' . $art)
                ->setAttributes([
                    'id' => $art,
                    'type' => '',
                    'available' => 'true',
                ]);

            $vendor = $product->getVendor();
            $model = $product->getModel();
            if (empty($vendor) || empty($model)) {
                $this->builder->addSubTag(['TAG' => 'name', 'VALUE' => $product->getName()]);
                $type = '';
            } else {
                $this->builder->addSubTag([
                    'TAG' => 'typePrefix',
                    'VALUE' => $product->getTypePrefix(),
                ]);
                $this->builder->addSubTag(['TAG' => 'vendor', 'VALUE' => $vendor]);

                $vendorCode = $product->getVendorCode();
                if (!empty($vendorCode)) {
                    $this->builder->addSubTag(['TAG' => 'vendorCode', 'VALUE' => $vendorCode]);
                }

                $this->builder->addSubTag(['TAG' => 'model', 'VALUE' => $model]);
                $type = 'vendor.model';
            }

            $this->builder->modifyTagAttributes('offer_' . $art, ['type' => $type]);

            $this->builder->addSubTag(['TAG' => 'url', 'VALUE' => $product->getUrl()]);
            $this->builder->addSubTag(['TAG' => 'price', 'VALUE' => $product->getPrice()]);
            $this->builder->addSubTag(['TAG' => 'currencyId', 'VALUE' => $product->getCurrency()]);
            $this->builder->addSubTag(['TAG' => 'categoryId', 'VALUE' => $product->getFeedCategoryId()]);
            $this->builder->addSubTag(['TAG' => 'picture', 'VALUE' => $product->getPicture()]);

            $additionalImages = $product->getAdditionalImages();
            if (!empty($additionalImages)) {
                foreach ($additionalImages as $additionalImage) {
                    $this->builder->addSubTag(['TAG' => 'picture', 'VALUE' => $additionalImage]);
                }
            }

            $this->builder->addSubTag(['TAG' => 'delivery', 'VALUE' => $product->getDelivery()]);
            $this->builder->addSubTag(['TAG' => 'description', 'VALUE' => $product->getDescription()]);
            $this->builder->addSubTag([
                'TAG' => 'manufacturer_warranty',
                'VALUE' => $product->getManufacturerWarranty(),
            ]);
            $this->builder->addSubTag(['TAG' => 'country_of_origin', 'VALUE' => $product->getCountry()]);

            $salesNotes = $product->getSalesNotes();
            if (!empty($salesNotes)) {
                $this->builder->addSubTag(['TAG' => 'sales_notes', 'VALUE' => $salesNotes]);
            }

            $arDeliveryPrice = $product->getDeliveryPrice();
            $this->builder->addSubTag([
                'TAG' => 'delivery-options',
                'SUB_TAGS' => [
                    [
                        'TAG' => 'option',
                        'ATTRIBUTES' => ['cost' => $arDeliveryPrice['PRICE'], 'days' => $arDeliveryPrice['DAYS']],
                        'SINGLE' => true,
                    ],
                ],
            ]);

            $arParams = $product->getParams();
            if ($arParams) {
                foreach ($arParams as $arParam) {
                    $this->builder->addSubTag([
                        'TAG' => 'param',
                        'VALUE' => $arParam['VALUE'],
                        'ATTRIBUTES' => [
                            'name' => $arParam['NAME'],
                            'unit' => $arParam['UNIT'],
                        ],
                    ]);
                }
            }
        }

        $this->result = $this->builder->build();
    }


    /**
     * @param array $categories
     */
    private function buildCategories(array $categories)
    {
        $this->buildCategoriesTags($categories);
        $this->result = $this->builder->build();
    }

    private function buildCategoriesTags(array $categories)
    {
        /** @var FeedCategory $category */
        foreach ($categories as $category) {
            $categoryId = $category->getId();
            $this->builder->newTag('category', 'category_' . $categoryId)
                ->setValue($category->getName())
                ->setAttributes([
                    'id' => $categoryId,
                    'parentId' => $category->getParentId(),
                ]);

            $children = $category->getChildren();
            if (!empty($children)) {
                $this->buildCategoriesTags($children);
            }
        }
    }

    /**
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }
}
