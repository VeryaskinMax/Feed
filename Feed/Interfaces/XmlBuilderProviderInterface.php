<?php

namespace vmax\Feed\Interfaces;

interface XmlBuilderProviderInterface
{
    public function newTag($tag_name, $tag_id = null);

    public function newRaw($text = '');

    public function setValue($tag_value);

    public function single();

    public function buildNode($arTag = []);

    public function setAttributes($attributes = []);

    public function modifyTagAttributes($tag_id, $arAttributes = []);

    public function addSubTag($arSubTag = []);

    public function build();

    public function get(): string;
}
