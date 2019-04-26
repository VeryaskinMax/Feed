<?php

namespace santon\Feed\DataBuilders\Xml;

use santon\Feed\Entities\FeedCategory;
use santon\Feed\Entities\FeedProductGoogle;
use santon\Feed\Exceptions\FeedEntityException;
use santon\Feed\Exceptions\FeedXmlBuilderException;
use santon\Feed\Interfaces\DataBuilderInterface;
use santon\Feed\Interfaces\FeedInterface;
use santon\Feed\Interfaces\XmlBuilderProviderInterface;

class GoogleMerchantXmlBuilder implements DataBuilderInterface
{
    const BUILD_TYPE_PRODUCT = 'productGoogle';
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
                throw new FeedEntityException(sprintf("Entity '%s' not found", $entityType));
        }

        return $this;
    }

    /**
     * @param array $products
     */
    private function buildProducts(array $products)
    {
        /** @var FeedProductGoogle $product */
        foreach ($products as $product) {
            $art = $product->getArt();
            $this->builder->newTag('item', 'item_' . $art)
                ->setAttributes([
                    'id' => $art,
                    'type' => 'vendor.model',
                    'available' => 'true',
                ]);

            $this->builder->addSubTag(['TAG' => 'title', 'VALUE' => $product->getTitle()]);
            $this->builder->addSubTag(['TAG' => 'link', 'VALUE' => $product->getLink()]);
            $this->builder->addSubTag(['TAG' => 'description', 'VALUE' => $product->getDescription()]);
            $this->builder->addSubTag([
                'TAG' => 'g:product_type',
                'VALUE' => $product->getProductType(),
            ]);
            $this->builder->addSubTag(['TAG' => 'g:id', 'VALUE' => $art]);
            $this->builder->addSubTag(['TAG' => 'g:brand', 'VALUE' => $product->getBrand()]);
            $this->builder->addSubTag(['TAG' => 'g:availability', 'VALUE' => $product->getAvailability()]);
            $this->builder->addSubTag([
                'TAG' => 'g:google_product_category',
                'VALUE' => $product->getGoogleProductCategory(),
            ]);
            $this->builder->addSubTag([
                'TAG' => 'g:custom_label_0',
                'VALUE' => $product->getCustomLabel0(),
            ]);

            $customLabel1 = $product->getCustomLabel1();
            if ($customLabel1) {
                $this->builder->addSubTag([
                    'TAG' => 'g:custom_label_1',
                    'VALUE' => $product->getCustomLabel1(),
                ]);
            }

            $this->builder->addSubTag(['TAG' => 'g:image_link', 'VALUE' => $product->getImage()]);
            $this->builder->addSubTag([
                'TAG' => 'g:price',
                'VALUE' => $product->getPrice() . ' ' . $product->getCurrency(),
            ]);
            $this->builder->addSubTag(['TAG' => 'g:adwords_grouping', 'VALUE' => $product->getAdwordsGrouping()]);
            $this->builder->addSubTag(['TAG' => 'g:condition', 'VALUE' => $product->getCondition()]);

            $gtin = $product->getGtin();
            $mpn = $product->getMpn();
            if (!empty($gtin)) {
                $nodeIdentifier = ['TAG' => 'g:gtin', 'VALUE' => $gtin];
            } elseif (!empty($mpn)) {
                $nodeIdentifier = ['TAG' => 'g:mpn', 'VALUE' => $mpn];
            } else {
                $nodeIdentifier = ['TAG' => 'g:identifier_exists', 'VALUE' => 'no'];
            }

            $additionalImages = $product->getAdditionalImages();
            if (!empty($additionalImages)) {
                foreach ($additionalImages as $additionalImage) {
                    $this->builder->addSubTag(['TAG' => 'g:additional_image_link', 'VALUE' => $additionalImage]);
                }
            }

            $this->builder->addSubTag($nodeIdentifier);
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

    /**
     * @param array $categories
     */
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
