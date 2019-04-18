<?php

namespace vmax\Feed\DataCollectors\Bitrix;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\Field;
use Bitrix\Main\Entity\Query;
use vmax\Feed\Interfaces\DataCollectorInterface;

class ProductsCollector implements DataCollectorInterface
{
    /** @var int  */
    private $productsPerStep = 1000;
    /** @var Query */
    private $queryBuilder;
    /** @var DataManager  */
    private $dbModelObject;
    /** @var array  */
    private $tableFields = [];

    public function __construct(DataManager $dataBaseTableModel)
    {
        $this->dbModelObject = $dataBaseTableModel;
        $this->queryBuilder = $this->dbModelObject::query();
        $this->setTableFields();
    }

    /**
     * @return DataManager
     */
    private function getDbModelObject()
    {
        return $this->dbModelObject;
    }
    /**
     * @return Query
     */
    public function getQueryBuilder(): Query
    {
        return $this->queryBuilder;
    }
    /**
     * @param int $productsPerStep
     */
    public function setProductsPerStep(int $productsPerStep)
    {
        $this->productsPerStep = $productsPerStep;
    }

    /**
     * @return int
     */
    public function getProductsPerStep(): int
    {
        return $this->productsPerStep;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->getQueryBuilder()->setSelect(['PRODUCT_ID'])->exec()->getSelectedRowsCount();
    }

    /**
     * @param int $productsCount
     *
     * @return int
     */
    public function getIterationSteps(int $productsCount): int
    {
        $totalSteps = (int)($productsCount / $this->productsPerStep);
        if ($totalSteps === 0) {
            $totalSteps = 1;
        }

        return $totalSteps;
    }


    private function setTableFields()
    {
        $arFields = $this->dbModelObject::getMap();
        if ($arFields) {
            /**@var $obField Field */
            foreach ($arFields as $obField) {
                $this->tableFields[] = $obField->getName();
            }
        }

        return $this;
    }

    /**
     * @return array
     * @throws \Bitrix\Main\ArgumentException
     */
    public function getCollection(): array
    {
        $parameters = [
            'select' => $this->tableFields,
            'filter' => $this->getQueryBuilder()->getFilter(),
            'limit'  => $this->getQueryBuilder()->getLimit(),
            'offset' => $this->getQueryBuilder()->getOffset(),
            'order'  => $this->getQueryBuilder()->getOrder()
        ];
        $getProducts = $this->getDbModelObject()::getList($parameters);
        $arProducts = [];

        while ($arProduct = $getProducts->fetch()) {
            $arProducts[] = $arProduct;
        }

        return $arProducts;
    }
}
