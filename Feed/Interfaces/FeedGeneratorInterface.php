<?php

namespace santon\Feed\Interfaces;

interface FeedGeneratorInterface
{
    public function writeToFile(string $data);
}
