<?php

use PayZero\App\Console\ArgumentReader;
use PayZero\App\Entity\Currency;
use PayZero\App\Entity\Operation;
use PayZero\App\Entity\User;
use PayZero\App\Exception\Console\CvsFormatNotSupportedException;
use PayZero\App\Exception\Console\FileDoesNotExist;
use PayZero\App\Exception\Console\FirstArgumentMissingException;
use PayZero\App\Factory\ClientType;
use PayZero\App\Factory\OperationType;
use PayZero\App\File\CsvReader;
use PayZero\App\File\File;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Processor\ReaderToOperation;
use PayZero\App\Service\ExchangeRate\ExchangeRate;

require  __DIR__ . '/vendor/autoload.php';

const ROOT_DIR = __DIR__;

try {
    $argumentReader = new ArgumentReader($argv); //read arguments
    $file = new File($argumentReader->getFirstArgument(), __DIR__); //creating file object
    $csvReader = new CsvReader($file); // creating csv reader to parse the csv file from arg #1
    $csvToOperation = new ReaderToOperation($csvReader);

    $processor = new OperationToCommission($csvToOperation->getOperations(), new ExchangeRate());
    $processor->getCalculatedCommissions();
} catch (FirstArgumentMissingException|CvsFormatNotSupportedException $e) {
    print $e->getMessage()."\n";
    exit;
} catch (FileDoesNotExist $e) {
    print $e->getMessage()." Check the first argument\n";
    exit;
}
