<?php

namespace vmax\Feed\Config;

use vmax\Feed\Interfaces\FeedConfigInterface;

abstract class FeedConfig implements FeedConfigInterface
{

    /** @var string  */
    protected $hostName = "https://somesite.com";

    /**
     * @return string
     */
    public function getHostName(): string
    {
        return $this->hostName;
    }

    /**
     * @return array
     */
    public function getCategories(): array
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
                        'GPC' => 1636
                    ],
                    [
                        'ID' => 4,
                        'REAL_ID' => 4914,
                        'PARENT_ID' => 2,
                        'NAME' => 'Чугунные ванны',
                        'GPC' => 1636
                    ],
                ]
            ]
        ];
    }
}
