<?php

namespace vmax\Feed\Interfaces;

interface DataBuilderInterface
{
    public function build(FeedInterface $feed);

    public function getResult(): string;
}
