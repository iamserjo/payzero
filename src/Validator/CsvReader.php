<?php

declare(strict_types=1);

namespace PayZero\App\Validator;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\CsvFormatNotSupportedException;

class CsvReader implements Validator
{
    /**
     * @throws CsvFormatNotSupportedException
     */
    public function validate($data): void
    {
        $this->assertCountValid($data);

        $this->assertDateValid($data[0]);
        $this->assertUserValid($data[1]);
        $this->assertClientTypeValid($data[2]);
        $this->assertOperationTypeValid($data[3]);
        $this->assertAmountValueValid($data[4]);
        $this->assertCurrencyValid($data[5]);
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertCountValid($line): void
    {
        if (count($line) !== 6) {
            throw new CsvFormatNotSupportedException('File format is not supported');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertDateValid($value): void
    {
        if (!strtotime($value)) {
            throw new CsvFormatNotSupportedException('Date '.$value.' is not valid');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertUserValid($value): void
    {
        if (!ctype_digit($value)) {
            throw new CsvFormatNotSupportedException('User id "'.$value.'" is not a number');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertClientTypeValid($value): void
    {
        if (!in_array($value, ['business', 'private'], true)) {
            throw new CsvFormatNotSupportedException('Client type '.$value.' is not valid');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertOperationTypeValid($value): void
    {
        if (!in_array($value, ['withdraw', 'deposit'], true)) {
            throw new CsvFormatNotSupportedException('Operation type '.$value.' is not valid');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertAmountValueValid($value): void
    {
        if (!is_numeric($value)) {
            throw new CsvFormatNotSupportedException('Amount value '.$value.' is not valid');
        }
    }

    /**
     * @throws CsvFormatNotSupportedException
     */
    private function assertCurrencyValid($string): void
    {
        if (strlen($string) !== 3) { // it will be double-checked later in the code for existing the currency
            throw new CsvFormatNotSupportedException('Currency value '.$string.' is not valid');
        }
    }
}
