<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Contract\Reader;
use PayZero\App\Contract\Validator;
use PayZero\App\Exception\CsvFormatNotSupportedException;

class CsvReader implements Reader
{
    public function __construct(private readonly Validator $validator, private readonly File $file)
    {
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    public function readFile(): \Generator
    {
        if (($handle = fopen($this->file->getFilePath(), 'r')) !== false) {
            while (($csvDataLine = fgetcsv($handle, 1000, ',')) !== false) {
                $this->validator->validate($csvDataLine);
                yield $csvDataLine;
            }
            fclose($handle);
        }
    }
}
