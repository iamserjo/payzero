<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Exception\Console\FileDoesNotExist;

class File
{
    /**
     * @throws FileDoesNotExist
     */
    public function __construct(private readonly string $fileName, private readonly string $directory = __DIR__)
    {
        $this->assertFileExists();
        echo $this->fileName;
    }

    public function getFilePath()
    {
        return $this->directory.'/'.$this->fileName;
    }

    /**
     * @throws FileDoesNotExist
     */
    private function assertFileExists(): void
    {
        if (!file_exists($this->getFilePath())) {
            throw new FileDoesNotExist('File does not exist.');
        }
    }
}