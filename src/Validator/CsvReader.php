<?php

namespace PayZero\App\Validator;

use PayZero\App\Contract\Validator;
use PayZero\App\Exception\CvsFormatNotSupportedException;

class CsvReader implements Validator
{
    /**
     * @throws CvsFormatNotSupportedException
     */
    public function validate($data): void
    {
        foreach ($data as $line) {
            $this->assertCountValid($line);

            $this->assertDateValid($line[0]);
            $this->assertUserValid($line[1]);
            $this->assertClientTypeValid($line[2]);
            $this->assertOperationTypeValid($line[3]);
            $this->assertAmountValueValid($line[4]);
            $this->assertCurrencyValid($line[5]);
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertCountValid($line): void
    {
        if (count($line) !== 6) {
            throw new CvsFormatNotSupportedException('File format is not supported');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertDateValid($value): void
    {
        if (!strtotime($value)) {
            throw new CvsFormatNotSupportedException('Date ' . $value . ' is not valid');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertUserValid($value): void
    {
        if (!ctype_digit($value)) {
            throw new CvsFormatNotSupportedException('User id "' . $value . '" is not a number');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertClientTypeValid($value): void
    {
        if (!in_array($value, ['business', 'private'])) {
            throw new CvsFormatNotSupportedException('Client type ' . $value . ' is not valid');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertOperationTypeValid($value): void
    {
        if (!in_array($value, ['withdraw', 'deposit'])) {
            throw new CvsFormatNotSupportedException('Operation type ' . $value . ' is not valid');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertAmountValueValid($value): void
    {
        if (!is_numeric($value)) {
            throw new CvsFormatNotSupportedException('Amount value ' . $value . ' is not valid');
        }
    }

    /**
     * @throws CvsFormatNotSupportedException
     */
    private function assertCurrencyValid($string): void
    {
        if (strlen($string) !== 3) { //it will be double-checked later in the code for existing the currency
            throw new CvsFormatNotSupportedException('Currency value ' . $string . ' is not valid');
        }
    }
}