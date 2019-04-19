<?php

namespace vmax\Feed\Feeds;

use vmax\Feed\Interfaces\FeedInterface;

abstract class AbstractFeed implements FeedInterface
{

    protected $data = [];
    /** @var string */
    protected $feedEntity;

    /**
     * @param string $feedEntity
     */
    public function switchEntity(string $feedEntity)
    {
        $this->data = []; // clear data for new entity
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
}
