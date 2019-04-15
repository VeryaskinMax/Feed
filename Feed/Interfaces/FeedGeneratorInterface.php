<?php

namespace vmax\Feed\Interfaces;

interface FeedGeneratorInterface
{
    public function writeToFile(string $data);
}
