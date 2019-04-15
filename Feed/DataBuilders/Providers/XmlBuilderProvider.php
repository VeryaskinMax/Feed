<?php

namespace vmax\Feed\DataBuilders\Providers;

use vmax\Feed\Interfaces\XmlBuilderProviderInterface;

class XmlBuilderProvider implements XmlBuilderProviderInterface
{

    /** @var array */
    public $xmlNode = [];
    /** @var mixed */
    public $lastOpenedTagId = false;

    /** @var string */
    private $result;

    /**
     * @param      $tag_name
     * @param null $tag_id
     *
     * @return $this
     * Метод добавляет новый тег в конструктор
     */
    public function newTag($tag_name, $tag_id = null): self
    {
        $tag_id = $tag_id ?: 0;
        $this->xmlNode[$tag_id]['TAG'] = $tag_name;
        $this->xmlNode[$tag_id]['VALUE'] = '';
        $this->lastOpenedTagId = $tag_id;

        return $this;
    }

    /**
     * @param string $text
     *
     * @return $this
     * Метод создает новый текстовый узел
     */
    public function newRaw($text = ''): self
    {
        $this->result = $text;

        return $this;
    }

    /**
     * @param $tag_value
     *
     * @return $this
     * Метод устанавливает значение одиночного тега
     */
    public function setValue($tag_value): self
    {
        $this->xmlNode[$this->lastOpenedTagId]['VALUE'] = !empty($tag_value) ? $tag_value : '';

        return $this;
    }

    /**
     * @return $this
     * Метод помечает текущий тег как "одиночку"
     */
    public function single(): self
    {
        $this->xmlNode[$this->lastOpenedTagId]['SINGLE'] = true;

        return $this;
    }

    /**
     * @param array $arTag
     * Метод строит тег в текстовый узел
     */
    public function buildNode($arTag = [])
    {
        if (!empty($arTag['TAG'])) {
            $this->result .= '<' . $arTag['TAG'];

            if (!empty($arTag['ATTRIBUTES'])) {
                foreach ($arTag['ATTRIBUTES'] as $name => &$value) {
                    if (null !== $value && $value !== '') {
                        $this->result .= ' ' . $name . '="' . $value . '"';
                    }
                }

                unset($value);
            }

            $this->result = trim($this->result);
            if (isset($arTag['SINGLE']) && $arTag['SINGLE'] === true) {
                $this->result .= " />\n";
            } else {
                $this->result .= '>';

                if (isset($arTag['VALUE'])) {
                    $this->result .= $arTag['VALUE'];
                }
            }

            if (!empty($arTag['SUB_TAGS'])) {
                $this->result .= "\n";

                foreach ($arTag['SUB_TAGS'] as &$arSubNode) {
                    $this->buildNode($arSubNode);
                }

                unset($arSubNode);
            }

            if (isset($arTag['SINGLE']) !== true) {
                $this->result .= '</' . $arTag['TAG'] . ">\n";
            }
        }
    }

    /**
     * @return string
     * Метод строит теги в текстовые узлы
     */
    public function build(): string
    {

        $this->result = '';

        foreach ($this->xmlNode as $arNode) {
            $this->buildNode($arNode);
        }

        $this->lastOpenedTagId = false;
        $this->xmlNode = [];

        return $this->result;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     * Метод устанавливает атрибуты для текущего тега
     */
    public function setAttributes($attributes = []): self
    {
        if (!empty($attributes) && is_array($attributes)) {
            foreach ($attributes as $name => $value) {
                $this->xmlNode[$this->lastOpenedTagId]['ATTRIBUTES'][$name] = $value;
            }
        }

        return $this;
    }

    /**
     * @param       $tag_id
     * @param array $arAttributes
     *
     * @return $this
     * Метод модифицирует атрибуты текущего тега
     */
    public function modifyTagAttributes($tag_id, $arAttributes = []): self
    {

        foreach ($arAttributes as $name => $value) {
            $this->xmlNode[$tag_id]['ATTRIBUTES'][$name] = $value;
        }

        return $this;
    }

    /**
     * @param array $arSubTag
     *
     * @return $this
     * Метод добавляет вложенный тег текущему тегу
     * addSubTag([
     * 'TAG' => 'tagname',
     * 'SINGLE' => true,
     * 'ATTRIBUTES' => [
     * 'id'=>'some id',
     * 'rate'=>'1'
     * ],
     *      'SUB_TAGS' => [[...],[...],...]
     * ]);
     */
    public function addSubTag($arSubTag = []): self
    {

        if (!empty($arSubTag['TAG']) && is_array($arSubTag)) {
            $this->xmlNode[$this->lastOpenedTagId]['SUB_TAGS'][] = $arSubTag;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return $this->result;
    }
}
