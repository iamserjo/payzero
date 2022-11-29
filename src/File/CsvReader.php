<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Exception\Console\CvsFormatNotSupportedException;

class CsvReader implements Reader
{
    private array $output = [];

    /**
     * @throws CvsFormatNotSupportedException
     */
    public function __construct(private readonly File $file)
    {
        $this->readFile();
        $this->validateFile();
    }

    public function getLines(): array
    {
        return $this->output;
    }

    private function readFile(): void
    {
        if (($handle = fopen($this->file->getFilePath(), 'r')) !== false) {
            while (($csvDataLine = fgetcsv($handle, 1000, ',')) !== false) {
                $this->output[] = $csvDataLine;
            }
            fclose($handle);
        }
    }

    private function validateFile(): void
    {
        foreach ($this->output as $line) {
            if (count($line) !== 6) {
                throw new CvsFormatNotSupportedException('File format is not supported');
            }
        }
    }
}
