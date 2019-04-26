<?php

namespace santon\Feed\Interfaces;

interface DataBuilderInterface
{
    public function build(FeedInterface $feed);
    public function getResult(): string;
}
