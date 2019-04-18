<?php

namespace vmax\Feed\DataCollectors\Bitrix;

use vmax\Feed\Config\FeedConfig;
use vmax\Feed\Interfaces\DataCollectorInterface;

class CategoriesCollector implements DataCollectorInterface
{
    const CONFIG_PARAM_CATEGORIES = 'categories';

    /** @var FeedConfig  */
    private $config;

    public function __construct(FeedConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->config->getCategories();
    }
}
