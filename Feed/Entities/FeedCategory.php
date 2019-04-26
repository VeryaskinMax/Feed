<?php

namespace santon\Feed\Entities;

use santon\Feed\Interfaces\FeedEntityInterface;

class FeedCategory implements FeedEntityInterface
{
    const ENTITY_TYPE = 'category';

    /** @var int */
    private $id;
    /** @var int */
    private $realId;
    /** @var string */
    private $name;
    /** @var int */
    private $parentId;
    /** @var int */
    private $gpc;
    /** @var string */
    private $code;
    /** @var array */
    private $children;

    public function __construct(array $category)
    {
        $this->setFeedId($category['ID'] ?: 0);
        $this->setParentId($category['PARENT_ID'] ?: 0);
        $this->setRealId($category['REAL_ID'] ?: 0);
        $this->setName($category['NAME'] ?: '');
        $this->setCode($category['CODE'] ?: '');
        $this->setGpc($category['GPC'] ?: 0);
        $this->setChildren($category['CHILDREN'] ?: []);
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
    public function setFeedId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getRealId(): int
    {
        return $this->realId;
    }

    /**
     * @param int $realId
     */
    public function setRealId(int $realId)
    {
        $this->realId = $realId;
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
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId)
    {
        $this->parentId = $parentId;
    }

    /**
     * @return int
     */
    public function getGpc(): int
    {
        return $this->gpc;
    }

    /**
     * @param int $gpc
     */
    public function setGpc(int $gpc)
    {
        $this->gpc = $gpc;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::ENTITY_TYPE;
    }

    /**
     * @return mixed
     */
    public function getChildren(): array
    {
        return $this->children;
    }

    /**
     * @param array $children
     */
    public function setChildren(array $children)
    {
        $this->children = $children;
    }
}
