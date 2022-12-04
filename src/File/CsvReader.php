<?php

declare(strict_types=1);

namespace PayZero\App\File;

use PayZero\App\Contract\Reader;
use PayZero\App\Exception\CvsFormatNotSupportedException;

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
        // TODO: change to generators
        if (($handle = fopen($this->file->getFilePath(), 'r')) !== false) {
            while (($csvDataLine = fgetcsv($handle, 1000, ',')) !== false) {
                $this->output[] = $csvDataLine;
            }
            fclose($handle);
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function validateFile(): void
    {
        (new \PayZero\App\Validator\CsvReader())->validate($this->output);
    }
}
