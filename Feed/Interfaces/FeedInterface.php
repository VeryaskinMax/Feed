<?php

namespace santon\Feed\Interfaces;

interface FeedInterface
{
    public function getData();
    public function getEntityType(): string;
}
