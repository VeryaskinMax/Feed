<?php

namespace vmax\Feed\DataCollectors\Bitrix;

use vmax\Feed\Interfaces\DataCollectorInterface;
use vmax\Feed\Interfaces\FeedConfigInterface;

class CategoriesCollector implements DataCollectorInterface
{

    const CONFIG_PARAM_CATEGORIES = 'categories';

    /** @var FeedConfigInterface */
    private $config;

    public function __construct(FeedConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return mixed
     */
    public function getCollection()
    {
        return $this->config->get(self::CONFIG_PARAM_CATEGORIES);
    }
}
