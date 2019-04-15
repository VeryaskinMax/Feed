<?php

namespace vmax\Feed\Generators;

use vmax\Feed\Interfaces\FeedGeneratorInterface;

class XmlFeedGenerator implements FeedGeneratorInterface
{

    /** @var string */
    private $outputFile;

    public function __construct(string $filePath)
    {
        $this->outputFile = $filePath;
        $this->start();
    }

    /**
     * begins creating feed file
     */
    public function start()
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

    /**
     * finish up creating feed file
     */
    public function finish()
    {
        $this->createBackup();
        $this->createFeed();
    }

    /**
     * creates backup
     */
    public function createBackup()
    {
        if (file_exists($this->outputFile)) {
            rename($this->outputFile, $this->outputFile . '_old');
        }
    }

    /**
     * creates feed
     */
    public function createFeed()
    {
        if (file_exists($this->outputFile . '.tmp')) {
            rename($this->outputFile . '.tmp', $this->outputFile);
        }
    }

    /**
     * @param string $data
     */
    public function writeToFile(string $data)
    {
        if (!empty($data)) {
            file_put_contents($this->outputFile . '.tmp', $data, FILE_APPEND);
        }
    }
}
