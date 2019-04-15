<?php

namespace vmax\Feed;

use vmax\Feed\Interfaces\FeedConfigInterface;

class FeedConfig implements FeedConfigInterface
{
    const PARAM_CATEGORIES = 'categories';
    const PARAM_HOSTNAME = 'hostname';

    private $hostName = "https://santehnika-online.ru";


    /**
     * @param string $param
     *
     * @return array|bool|string
     */
    public function get(string $param)
    {
        switch ($param) {
            case self::PARAM_CATEGORIES:
                return $this->getCategories();
            case self::PARAM_HOSTNAME:
                return $this->hostName;
            default:
                return false;
        }
    }

    /**
     * @return array
     */
    private function getCategories(): array
    {
        return [
            [
                'ID' => 1,
                'REAL_ID' => 5572,
                'NAME' => 'Мебель для ванной',
            ],
            [
                'ID' => 2,
                'GPC' => 499999,
                'NAME' => 'Сантехника',
                'CHILDREN' => [
                    [
                        'ID' => 3,
                        'REAL_ID' => 4694,
                        'PARENT_ID' => 2,
                        'NAME' => 'Акриловые ванны',
                        'GPC' => 1636,
                    ],
                    [
                        'ID' => 4,
                        'REAL_ID' => 4914,
                        'PARENT_ID' => 2,
                        'NAME' => 'Чугунные ванны',
                        'GPC' => 1636,
                    ],
                ],
            ],
        ];
    }
}
