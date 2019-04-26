<?php

namespace santon\Feed\Config;

use santon\Feed\Interfaces\FeedConfigInterface;

abstract class FeedConfig implements FeedConfigInterface
{
    const REGION_ID = 2097; //default region (moscow)

    /** @var string */
    protected $hostName = "https://santehnika-online.ru";

    /**
     * @return string
     */
    public function getHostName(): string
    {
        return $this->hostName;
    }

    /**
     * @return int
     */
    public function getRegionId(): int
    {
        return static::REGION_ID;
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
                        'GPC' => 1636,
                    ],
                    [
                        'ID' => 4,
                        'REAL_ID' => 4914,
                        'PARENT_ID' => 2,
                        'NAME' => 'Чугунные ванны',
                        'GPC' => 1636,
                    ],
                    [
                        'ID' => 5,
                        'REAL_ID' => 6296,
                        'PARENT_ID' => 2,
                        'NAME' => 'Стальные ванны',
                        'GPC' => 1636,
                    ],
                    [
                        'ID' => 6,
                        'REAL_ID' => 8229,
                        'PARENT_ID' => 2,
                        'NAME' => 'Ванны из искусственного камня',
                        'GPC' => 1636,
                    ],
                    [
                        'ID' => 7,
                        'REAL_ID' => 4975,
                        'PARENT_ID' => 2,
                        'NAME' => 'Унитазы',
                        'GPC' => 1921,
                    ],
                    [
                        'ID' => 8,
                        'REAL_ID' => 5134,
                        'PARENT_ID' => 2,
                        'NAME' => 'Раковины',
                        'GPC' => 1687,
                    ],
                    [
                        'ID' => 9,
                        'REAL_ID' => 5314,
                        'PARENT_ID' => 2,
                        'NAME' => 'Смесители',
                        'GPC' => 504638,
                    ],
                    [
                        'ID' => 10,
                        'REAL_ID' => 6050,
                        'PARENT_ID' => 2,
                        'NAME' => 'Душ',
                        'GPC' => 7244,
                    ],
                    [
                        'ID' => 11,
                        'REAL_ID' => 4335,
                        'PARENT_ID' => 2,
                        'NAME' => 'Душевые кабины',
                        'GPC' => 7244,
                    ],
                    [
                        'ID' => 12,
                        'REAL_ID' => 4656,
                        'PARENT_ID' => 2,
                        'NAME' => 'Душевые боксы',
                        'GPC' => 7244,
                    ],
                    [
                        'ID' => 13,
                        'REAL_ID' => 5760,
                        'PARENT_ID' => 2,
                        'NAME' => 'Уголки, ограждения, поддоны',
                        'GPC' => 7244,
                    ],
                    [
                        'ID' => 15,
                        'REAL_ID' => 6712,
                        'PARENT_ID' => 2,
                        'NAME' => 'Кухонные мойки',
                        'GPC' => 2757,
                    ],
                    [
                        'ID' => 40,
                        'REAL_ID' => 6746,
                        'PARENT_ID' => 2,
                        'NAME' => 'Диспоузеры(измельчители)',
                        'GPC' => 1963,
                    ],
                    [
                        'ID' => 16,
                        'REAL_ID' => 5736,
                        'PARENT_ID' => 2,
                        'NAME' => 'Инсталляции',
                        'GPC' => 2691,
                    ],
                    [
                        'ID' => 17,
                        'REAL_ID' => 5725,
                        'PARENT_ID' => 2,
                        'NAME' => 'Биде',
                        'GPC' => 2376,
                    ],
                    [
                        'ID' => 18,
                        'REAL_ID' => 6326,
                        'PARENT_ID' => 2,
                        'NAME' => 'Писсуары',
                        'GPC' => 1746,
                    ],
                    [
                        'ID' => 19,
                        'REAL_ID' => 6761,
                        'PARENT_ID' => 2,
                        'NAME' => 'Сифоны',
                        'GPC' => 1932,
                    ],
                    [
                        'ID' => 20,
                        'REAL_ID' => 6160,
                        'PARENT_ID' => 2,
                        'NAME' => 'Полотенцесушители',
                        'GPC' => 586,
                    ],
                    [
                        'ID' => 21,
                        'REAL_ID' => 6341,
                        'PARENT_ID' => 2,
                        'NAME' => 'Водонагреватели',
                        'GPC' => 621,
                    ],
                    [
                        'ID' => 22,
                        'REAL_ID' => 6794,
                        'PARENT_ID' => 2,
                        'NAME' => 'Трапы, душевые лотки',
                        'GPC' => 2206,
                    ],
                    [
                        'ID' => 23,
                        'REAL_ID' => 6686,
                        'PARENT_ID' => 2,
                        'NAME' => 'Теплые полы',
                        'GPC' => 1626,
                    ],
                    [
                        'ID' => 32,
                        'REAL_ID' => 7452,
                        'PARENT_ID' => 2,
                        'NAME' => 'Фильтры под мойку',
                        'GPC' => 2273,
                    ],
                ],
            ],
            [
                'ID' => 27,
                'NAME' => 'Водоснабжение и отопление',
                'CHILDREN' => [
                    [
                        'ID' => 26,
                        'REAL_ID' => 7078,
                        'PARENT_ID' => 27,
                        'NAME' => 'Котлы отопления',
                        'GPC' => 499873,
                    ],
                    [
                        'ID' => 36,
                        'REAL_ID' => 6579,
                        'PARENT_ID' => 27,
                        'NAME' => 'Радиаторы отопления',
                        'GPC' => 1626,
                    ],
                    [
                        'ID' => 29,
                        'REAL_ID' => 7339,
                        'PARENT_ID' => 27,
                        'NAME' => 'Насосы',
                        'GPC' => 500096,
                    ],
                    [
                        'ID' => 61,
                        'REAL_ID' => 7433,
                        'PARENT_ID' => 27,
                        'NAME' => 'Дымоходы',
                        'GPC' => 6792,
                    ],
                    [
                        'ID' => 41,
                        'REAL_ID' => 7228,
                        'PARENT_ID' => 27,
                        'NAME' => 'Трубы',
                        'GPC' => 2216,
                    ],
                    [
                        'ID' => 122,
                        'REAL_ID' => 6585,
                        'PARENT_ID' => 27,
                        'NAME' => 'Конвекторы',
                        'GPC' => 1626,
                    ],
                    [
                        'ID' => 42,
                        'REAL_ID' => 7297,
                        'PARENT_ID' => 27,
                        'NAME' => 'Фитинги',
                        'GPC' => 1810,
                    ],
                    [
                        'ID' => 43,
                        'REAL_ID' => 7402,
                        'PARENT_ID' => 27,
                        'NAME' => 'Запорная арматура',
                        'GPC' => 2611,
                    ],
                    [
                        'ID' => 125,
                        'REAL_ID' => 7088,
                        'PARENT_ID' => 27,
                        'NAME' => 'Автоматика для котлов',
                        'GPC' => 6773,
                    ],
                    [
                        'ID' => 45,
                        'REAL_ID' => 8653,
                        'PARENT_ID' => 27,
                        'NAME' => 'Системы защиты от протечек',
                        'GPC' => 503737,
                    ],
                    [
                        'ID' => 45,
                        'REAL_ID' => 7363,
                        'PARENT_ID' => 27,
                        'NAME' => 'Комплектующие для насосов',
                    ],
                ],
            ],
            [
                'ID' => 34,
                'NAME' => 'Вода и водоочистка',
                'CHILDREN' => [
                    [
                        'ID' => 31,
                        'REAL_ID' => 7364,
                        'PARENT_ID' => 34,
                        'NAME' => 'Диспенсеры для воды',
                        'GPC' => 2343,
                    ],
                    [
                        'ID' => 131,
                        'REAL_ID' => 7461,
                        'PARENT_ID' => 34,
                        'NAME' => 'Фильтры очистки',
                        'GPC' => 2055,
                    ],
                ]
            ],
            [
                'ID' => 28,
                'REAL_ID' => 7381,
                'NAME' => 'Баки расширительные',
                'GPC' => 500063
            ],
            [
                'ID' => 24,
                'REAL_ID' => 7421,
                'NAME' => 'Сантехнические люки',
                'GPC' => 2030
            ],
            [
                'ID' => 73,
                'NAME' => 'Клининг',
                'CHILDREN' => [
                    [
                        'ID' => 38,
                        'REAL_ID' => 7673,
                        'PARENT_ID' => 73,
                        'NAME' => 'Промышленные пылесосы',
                        'GPC' => 619,
                    ],
                    [
                        'ID' => 79,
                        'REAL_ID' => 9043,
                        'PARENT_ID' => 73,
                        'NAME' => 'Бытовая химия',
                        'GPC' => 623,
                    ],
                    [
                        'ID' => 47,
                        'REAL_ID' => 7028,
                        'PARENT_ID' => 73,
                        'NAME' => 'Урны',
                        'GPC' => 637,
                    ],
                    [
                        'ID' => 64,
                        'REAL_ID' => 7026,
                        'PARENT_ID' => 73,
                        'NAME' => 'Мешки для мусора',
                        'GPC' => 2374,
                    ],
                    [
                        'ID' => 49,
                        'REAL_ID' => 8353,
                        'PARENT_ID' => 73,
                        'NAME' => 'Сушилки для рук',
                        'GPC' => 5141,
                    ],
                    [
                        'ID' => 50,
                        'REAL_ID' => 7012,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры бумажных полотенец',
                        'GPC' => 3061,
                    ],
                    [
                        'ID' => 67,
                        'REAL_ID' => 7018,
                        'PARENT_ID' => 73,
                        'NAME' => 'Бумажные полотенца',
                        'GPC' => 2742,
                    ],
                    [
                        'ID' => 52,
                        'REAL_ID' => 7013,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для мыла',
                        'GPC' => 4971,
                    ],
                    [
                        'ID' => 69,
                        'REAL_ID' => 8798,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для антисептика',
                        'GPC' => 2954,
                    ],
                    [
                        'ID' => 70,
                        'REAL_ID' => 7019,
                        'PARENT_ID' => 73,
                        'NAME' => 'Жидкое мыло',
                        'GPC' => 3208,
                    ],
                    [
                        'ID' => 71,
                        'REAL_ID' => 7017,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры туалетной бумаги',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 72,
                        'REAL_ID' => 7023,
                        'PARENT_ID' => 73,
                        'NAME' => 'Туалетная бумага',
                        'GPC' => 629,
                    ],
                    [
                        'ID' => 56,
                        'REAL_ID' => 7024,
                        'PARENT_ID' => 73,
                        'NAME' => 'Фены для волос',
                        'GPC' => 490,
                    ],
                    [
                        'ID' => 57,
                        'REAL_ID' => 7014,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для освежителей воздуха',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 75,
                        'REAL_ID' => 7020,
                        'PARENT_ID' => 73,
                        'NAME' => 'Освежители воздуха',
                        'GPC' => 3898,
                    ],
                    [
                        'ID' => 76,
                        'REAL_ID' => 7016,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры сидений для унитаза',
                        'GPC' => 2691,
                    ],
                    [
                        'ID' => 77,
                        'REAL_ID' => 7022,
                        'PARENT_ID' => 73,
                        'NAME' => 'Покрытия на унитаз',
                        'GPC' => 7358,
                    ],
                    [
                        'ID' => 78,
                        'REAL_ID' => 7022,
                        'PARENT_ID' => 73,
                        'NAME' => 'Пепельницы',
                        'GPC' => 4082,
                    ],
                    [
                        'ID' => 62,
                        'REAL_ID' => 7034,
                        'PARENT_ID' => 73,
                        'NAME' => 'Увлажнители воздуха',
                        'GPC' => 613,
                    ],
                    [
                        'ID' => 63,
                        'REAL_ID' => 7031,
                        'PARENT_ID' => 73,
                        'NAME' => 'Мойки воздуха',
                        'GPC' => 613,
                    ],
                    [
                        'ID' => 81,
                        'REAL_ID' => 7033,
                        'PARENT_ID' => 73,
                        'NAME' => 'Очистители воздуха',
                        'GPC' => 613,
                    ],
                    [
                        'ID' => 82,
                        'REAL_ID' => 7015,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для салфеток',
                        'GPC' => 579,
                    ],
                    [
                        'ID' => 83,
                        'REAL_ID' => 7021,
                        'PARENT_ID' => 73,
                        'NAME' => 'Салфетки',
                        'GPC' => 3846,
                    ],
                    [
                        'ID' => 84,
                        'REAL_ID' => 7036,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для гигиенических пакетов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 85,
                        'REAL_ID' => 7029,
                        'PARENT_ID' => 73,
                        'NAME' => 'Гигиенические пакеты',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 86,
                        'REAL_ID' => 7035,
                        'PARENT_ID' => 73,
                        'NAME' => 'Диспенсеры для протирочных материалов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 87,
                        'REAL_ID' => 7030,
                        'PARENT_ID' => 73,
                        'NAME' => 'Протирочный материал',
                        'GPC' => 2250,
                    ],
                ]
            ],
            [
                'ID' => 14,
                'NAME' => 'Все аксессуары',
                'CHILDREN' => [
                    [
                        'ID' => 88,
                        'REAL_ID' => 6815,
                        'PARENT_ID' => 14,
                        'NAME' => 'Все Аксессуары',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 89,
                        'REAL_ID' => 6835,
                        'PARENT_ID' => 14,
                        'NAME' => 'Вешалки для полотенец',
                        'GPC' => 586,
                    ],
                    [
                        'ID' => 90,
                        'REAL_ID' => 8672,
                        'PARENT_ID' => 14,
                        'NAME' => 'Гидроершики',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 91,
                        'REAL_ID' => 6821,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели для газет и журналов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 92,
                        'REAL_ID' => 8660,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели для запасных рулонов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 93,
                        'REAL_ID' => 6822,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели для стаканов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 94,
                        'REAL_ID' => 6819,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели для фена',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 130,
                        'REAL_ID' => 6890,
                        'PARENT_ID' => 14,
                        'NAME' => 'Настенные держатели для фена',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 95,
                        'REAL_ID' => 8663,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели освежителя воздуха',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 96,
                        'REAL_ID' => 6820,
                        'PARENT_ID' => 14,
                        'NAME' => 'Боксы для салфеток',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 54,
                        'REAL_ID' => 7017,
                        'PARENT_ID' => 14,
                        'NAME' => 'Диспенсеры для туалетной бумаги',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 132,
                        'REAL_ID' => 6818,
                        'PARENT_ID' => 14,
                        'NAME' => 'Держатели для туалетной бумаги',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 98,
                        'REAL_ID' => 8666,
                        'PARENT_ID' => 14,
                        'NAME' => 'Диспенсеры для ватных дисков',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 99,
                        'REAL_ID' => 8667,
                        'PARENT_ID' => 14,
                        'NAME' => 'Дозаторы для мыла',
                        'GPC' => 4971,
                    ],
                    [
                        'ID' => 100,
                        'REAL_ID' => 8668,
                        'PARENT_ID' => 14,
                        'NAME' => 'Ершики',
                        'GPC' => 4971,
                    ],
                    [
                        'ID' => 101,
                        'REAL_ID' => 6826,
                        'PARENT_ID' => 14,
                        'NAME' => 'Карнизы для ванной',
                        'GPC' => 1962,
                    ],
                    [
                        'ID' => 102,
                        'REAL_ID' => 8670,
                        'PARENT_ID' => 14,
                        'NAME' => 'Коврики',
                        'GPC' => 577,
                    ],
                    [
                        'ID' => 103,
                        'REAL_ID' => 6838,
                        'PARENT_ID' => 14,
                        'NAME' => 'Контейнеры для ванной комнаты',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 104,
                        'REAL_ID' => 6817,
                        'PARENT_ID' => 14,
                        'NAME' => 'Корзины для белья',
                        'GPC' => 634,
                    ],
                    [
                        'ID' => 105,
                        'REAL_ID' => 6832,
                        'PARENT_ID' => 14,
                        'NAME' => 'Косметические зеркала',
                        'GPC' => 476,
                    ],
                    [
                        'ID' => 106,
                        'REAL_ID' => 6834,
                        'PARENT_ID' => 14,
                        'NAME' => 'Крючки для ванной',
                        'GPC' => 2034,
                    ],
                    [
                        'ID' => 107,
                        'REAL_ID' => 8675,
                        'PARENT_ID' => 14,
                        'NAME' => 'Крючки для штор',
                        'GPC' => 578,
                    ],
                    [
                        'ID' => 108,
                        'REAL_ID' => 6824,
                        'PARENT_ID' => 14,
                        'NAME' => 'Мыльницы',
                        'GPC' => 582,
                    ],
                    [
                        'ID' => 109,
                        'REAL_ID' => 8678,
                        'PARENT_ID' => 14,
                        'NAME' => 'Подставки для предметов',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 110,
                        'REAL_ID' => 6825,
                        'PARENT_ID' => 14,
                        'NAME' => 'Полки в ванную комнату',
                        'GPC' => 575,
                    ],
                    [
                        'ID' => 111,
                        'REAL_ID' => 6833,
                        'PARENT_ID' => 14,
                        'NAME' => 'Полотенцедержатели',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 112,
                        'REAL_ID' => 8114,
                        'PARENT_ID' => 14,
                        'NAME' => 'Поручни для ванной',
                        'GPC' => 6836,
                    ],
                    [
                        'ID' => 113,
                        'REAL_ID' => 8676,
                        'PARENT_ID' => 14,
                        'NAME' => 'Скребки',
                    ],
                    [
                        'ID' => 114,
                        'REAL_ID' => 6837,
                        'PARENT_ID' => 14,
                        'NAME' => 'Стаканы для ванной',
                        'GPC' => 574
                    ],
                    [
                        'ID' => 115,
                        'REAL_ID' => 6829,
                        'PARENT_ID' => 14,
                        'NAME' => 'Стойки для ванной',
                        'GPC' => 574,
                    ],
                    [
                        'ID' => 129,
                        'REAL_ID' => 6960,
                        'PARENT_ID' => 14,
                        'NAME' => 'Напольные стойки для ванной комнаты',
                        'GPC' => 574
                    ],
                    [
                        'ID' => 116,
                        'REAL_ID' => 6827,
                        'PARENT_ID' => 14,
                        'NAME' => 'Столики для ванны',
                        'GPC' => 574
                    ],
                    [
                        'ID' => 117,
                        'REAL_ID' => 6816,
                        'PARENT_ID' => 14,
                        'NAME' => 'Сушилки для белья',
                        'GPC' => 574
                    ],
                    [
                        'ID' => 118,
                        'REAL_ID' => 6831,
                        'PARENT_ID' => 14,
                        'NAME' => 'Мусорные ведра',
                        'GPC' => 637
                    ],
                    [
                        'ID' => 119,
                        'REAL_ID' => 8677,
                        'PARENT_ID' => 14,
                        'NAME' => 'Шторы для ванной',
                        'GPC' => 580
                    ],
                    [
                        'ID' => 120,
                        'REAL_ID' => 6839,
                        'PARENT_ID' => 14,
                        'NAME' => 'Наборы для ванной комнаты',
                        'GPC' => 6858
                    ],
                    [
                        'ID' => 124,
                        'REAL_ID' => 9098,
                        'PARENT_ID' => 14,
                        'NAME' => 'Товары для бани',
                    ],
                ]
            ],
            [
                'ID' => 97,
                'NAME' => 'Климат',
                'CHILDREN' => [
                    [
                        'ID' => 35,
                        'REAL_ID' => 6617,
                        'PARENT_ID' => 97,
                        'NAME' => 'Обогреватели',
                        'GPC' => 2060,
                    ],
                    [
                        'ID' => 37,
                        'REAL_ID' => 7671,
                        'PARENT_ID' => 97,
                        'NAME' => 'Кондиционеры',
                        'GPC' => 605,
                    ],
                    [
                        'ID' => 60,
                        'REAL_ID' => 7695,
                        'PARENT_ID' => 97,
                        'NAME' => 'Камины',
                        'GPC' => 6792,
                    ],
                    [
                        'ID' => 58,
                        'REAL_ID' => 7694,
                        'PARENT_ID' => 97,
                        'NAME' => 'Порталы',
                        'GPC' => 536,
                    ],
                    [
                        'ID' => 123,
                        'REAL_ID' => 8984,
                        'PARENT_ID' => 97,
                        'NAME' => 'Вытяжные вентиляторы',
                    ],
                ]
            ],
            [
                'ID' => 121,
                'REAL_ID' => 7740,
                'NAME' => 'Плитка',
            ],
        ];
    }
}
