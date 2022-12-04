<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Exception\FileDoesNotExist;

class File
{
    /**
     * @throws FileDoesNotExist
     */
    public function __construct(private readonly string $fileName, private readonly string $directory)
    {
        $this->assertFileExists();
    }

    public function getFilePath(): string
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
