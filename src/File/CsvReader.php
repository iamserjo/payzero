<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Contract\Reader;
use PayZero\App\Exception\CsvFormatNotSupportedException;

class CsvReader implements Reader
{
    private array $output = [];

    /**
     * @throws CsvFormatNotSupportedException
     */
    public function __construct(private readonly File $file)
    {
        $this->validateFile();
    }

    public function readFile(): \Generator
    {
        if (($handle = fopen($this->file->getFilePath(), 'r')) !== false) {
            while (($csvDataLine = fgetcsv($handle, 1000, ',')) !== false) {
                yield $csvDataLine;
            }
            fclose($handle);
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function validateFile(): void
    {
        (new \PayZero\App\Validator\CsvReader())->validate($this->output);
    }
}
