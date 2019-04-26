<?php

namespace santon\Feed\Generators;

use santon\Feed\Interfaces\FeedGeneratorInterface;

class FeedGenerator implements FeedGeneratorInterface
{
    /** @var string */
    private $outputFile;

    public function __construct(string $filePath)
    {
        $this->outputFile = $filePath;
        $this->start();
    }

    private function start()
    {
        $feedDirname = dirname($this->outputFile);
        if (!is_dir($feedDirname)) {
            if (@!mkdir($feedDirname, 0755, true)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $feedDirname));
            }
        }

        if (file_exists($this->outputFile . '.tmp')) {
            unlink($this->outputFile . '.tmp');
        }
    }

    public function finish()
    {
        $this->createBackup();
        $this->createFeed();
    }

    private function createBackup()
    {
        if (file_exists($this->outputFile)) {
            rename($this->outputFile, $this->outputFile . '_old');
        }
    }

    private function createFeed()
    {
        if (file_exists($this->outputFile . '.tmp')) {
            rename($this->outputFile . '.tmp', $this->outputFile);
        }
    }

    public function writeToFile(string $data)
    {
        if (!empty($data)) {
            file_put_contents($this->outputFile . '.tmp', $data, FILE_APPEND);
        }
    }
}
