<?php


namespace santon\Feed\Feeds;

use santon\Feed\Config\FeedConfig;
use santon\Feed\Entities\FeedCategory;
use santon\Feed\Interfaces\FeedInterface;

abstract class AbstractFeed implements FeedInterface
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
        'CATEGORY',
    ];

    protected $data = [];
    /** @var string */
    protected $feedEntity;
    /** @var FeedConfig */
    protected $config;

    public function __construct(FeedConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $feedEntity
     */
    public function switchEntity(string $feedEntity)
    {
        $this->data = []; // чищаем данные для работы с новой сущностью
        $this->feedEntity = $feedEntity;
    }

    /**
     * @return string
     */
    public function getEntityType(): string
    {
        return $this->feedEntity;
    }

    /**
     * @return FeedConfig
     */
    public function getConfig(): FeedConfig
    {
        return $this->config;
    }

    /**
     * @param array $data
     *
     */
    public function prepareData(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
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
            $getChildren = $obCategory->getChildren();
            if (!empty($getChildren)) {
                /** @var array $children */
                $children = $this->doPrepareCategoriesData($getChildren);
                $obCategory->setChildren($children);
            }
            $result[$obCategory->getId()] = $obCategory;
        }

        return $result;
    }
}
