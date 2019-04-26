<?php

namespace santon\Feed\Feeds\Google;

use santon\Feed\Config\FeedConfig;
use santon\Feed\Entities\FeedProductGoogle;
use santon\Feed\Feeds\AbstractFeed;

class GoogleMerchant extends AbstractFeed
{
    /** @var array */
    private $feedFlattenCategories;
    /** @var array */
    private $correctCategoriesNames = [
        'Баки' => 'Баки для воды',
        'Душевая программа' => 'Душ',
        'Диспенсеры туалетной бумаги' => 'Диспенсеры для туалетной бумаги',
        'Диспенсеры освежителя воздуха' => 'Диспенсеры для освежителей воздуха',
        'Покрытия на унитаз' => 'Покрытия на сиденье унитаза',
        'Материал протирочный' => 'Протирочный материал',
        'Котлы отопительные' => 'Котлы отопления',
        'Фильтры для воды' => 'Магистральные фильтры для очистки воды',
        'Мебель для ванной комнаты' => 'Мебель для ванной',
        'Радиаторы' => 'Радиаторы отопления',
        'Тёплые полы' => 'Теплые полы',
        'Трапы и душевые лотки' => 'Трапы для душа и душевые лотки',
        'Камины' => 'Электрокамины для квартиры и дома',
    ];

    public function __construct(FeedConfig $config)
    {
        parent::__construct($config);
        $this->flattenCategories($this->getConfig()->getCategories());
    }

    /**
     * @param array $data
     *
     * @return $this
     */
    public function prepareProducts(array $data): self
    {
        $preparedProducts = array_map([$this, 'doPrepareProducts'], $data);
        $this->data = array_map(static function ($arProduct) {
            return new FeedProductGoogle($arProduct);
        }, $preparedProducts);

        return $this;
    }

    /**
     * @param $product
     *
     * @return array
     */
    private function doPrepareProducts(array $product): array
    {
        $configHost = $this->getConfig()->getHostName();
        $properties = unserialize($product['PARAMS']);

        $name = $product['NAME'];
        if (strlen($name) > 70) {
            $name = $product['TYPE_PREFIX'] . ' ' . $product['VENDOR'] . ' ' . $product['MODEL'];
            if (strlen($name) > 70) {
                $name = $product['TYPE_PREFIX'] . ' ' . $product['VENDOR'];
            }
        }
        $product['NAME'] = $name;
        $product['DESCRIPTION'] = $this->getDescriptionFromProperties($properties);
        $product['PRODUCT_TYPE'] = $this->getProductType((int)$product['FEED_CATEGORY_ID']);

        $parsedUrl = parse_url($product['URL']);
        $urlSchemeHost = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
        if ($urlSchemeHost !== $configHost) {
            $product['URL'] = str_replace($urlSchemeHost, $configHost, $product['URL']);
        }

        if (!empty($product['ADDITIONAL_IMAGES'])) {
            $additionalImages = [];
            if (strpos($product['ADDITIONAL_IMAGES'], ';') !== false) {
                $additionalImages = explode(';', $product['ADDITIONAL_IMAGES']);
            } else {
                $additionalImages[] = $product['ADDITIONAL_IMAGES'];
            }
            $product['ADDITIONAL_IMAGES'] = $additionalImages;
        }

        $product['CUSTOM_LABEL_0'] = strtr($properties['CATEGORY']['VALUE'], $this->correctCategoriesNames) ?: '';
        if (in_array((int)$product['ART'], $this->getTemporaryElementsCustomLabel1(), true)) {
            $product['CUSTOM_LABEL_1'] = $name;
        }

        if (!empty($product['GTIN']) && !empty($product['MPN'])) {
            $product['IDENTIFIER'] = 'both';
        } elseif (!empty($product['GTIN'])) {
            $product['IDENTIFIER'] = 'mpn';
        } elseif (!empty($product['MPN'])) {
            $product['IDENTIFIER'] = 'mpn';
        }

        return $product;
    }

    /**
     * @param int $feedCategoryId
     *
     * @return string|bool
     */
    private function getProductType(int $feedCategoryId)
    {
        if (null !== $feedCategoryId) {
            $category = $this->feedFlattenCategories[$feedCategoryId];
            $parentId = $category['PARENT_ID'];
            if ($parentId > 0) {
                $product_type = $this->feedFlattenCategories[$parentId]['NAME'] . ' &gt; ' . $category['NAME'];
            } else {
                $product_type = $category['NAME'];
            }

            return $product_type;
        }

        return false;
    }

    /**
     * @param $properties
     *
     * @return string
     */
    private function getDescriptionFromProperties($properties): string
    {
        $imploded_props = '';

        foreach ($properties as $PROP_CODE => $oneProp) {
            if (empty($oneProp['NAME'])) {
                continue;
            }
            if (in_array($PROP_CODE, self::FILTERED_PARAMS, true)) {
                continue;
            }

            $arReplaces = ['true' => 'да', 'false' => 'нет'];
            $oneProp['VALUE'] = strtr($oneProp['VALUE'], $arReplaces);
            $imploded_props .= $oneProp['NAME'];

            if (!empty($oneProp['UNIT'])) {
                $imploded_props .= ' (' . $oneProp['UNIT'] . ')';
            }

            $imploded_props .= ': ' . $oneProp['VALUE'] . '; ';
        }

        return trim($imploded_props);
    }

    /**
     * return ВнутреннийАртикул ART
     * @return array
     */
    private function getTemporaryElementsCustomLabel1(): array
    {
        return [
            319062, 319097, 342450, 319059, 319095, 342439, 339521, 339519,  329011, 329002, 303398, 374923, 325066,
            229663, 374908, 374920, 325068, 325037, 297405, 374421, 368368, 262245, 367976, 265575, 244775,  204463,
            327214, 202214, 202213, 285508, 319914, 337451, 376613,  102607, 381138, 124964, 375163, 356218, 126564,
            356216, 347777, 332033, 363834, 323902, 276195, 302579, 360185, 329118, 332813, 348507,  372363, 360182,
            348517, 348526, 231497, 231528, 231652, 231512,  231525, 231503, 231533, 370859, 231496, 134101, 231873,
            253555, 292156, 110662, 317074, 376719, 135493, 316990, 259677, 343350, 276481,  345905, 276996, 298226,
            345910, 277018, 296570, 296469, 296715,  344252, 345232, 250663, 250917, 250913, 363525, 250899, 250635,
            363526, 250667, 307500, 360225, 250680, 250672, 363523, 361390, 217854,  355512, 335198, 334389, 114954,
            126468, 341888, 114081, 334380,  299756, 114939
        ];
    }

    /**
     * @param array $categories
     */
    private function flattenCategories(array $categories)
    {
        foreach ($categories as $category) {
            $this->feedFlattenCategories[$category['ID']] = $category;
            $children = $category['CHILDREN'];
            if (!empty($children)) {
                $this->flattenCategories($children);
            }
        }
    }
}
