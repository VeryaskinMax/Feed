<?php

namespace vmax\Feed\Interfaces;

interface FeedInterface
{
    public function getData();

    public function getEntityType(): string;
}
