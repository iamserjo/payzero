<?php

use PayZero\App\Console\ArgumentReader;
use PayZero\App\Exception\CvsFormatNotSupportedException;
use PayZero\App\Exception\FileDoesNotExist;
use PayZero\App\Exception\ConsoleArgumentMissingException;
use PayZero\App\File\CsvReader;
use PayZero\App\File\File;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Processor\ReaderToOperation;
use Symfony\Component\Dotenv\Dotenv;

require  __DIR__ . '/vendor/autoload.php';

try {

    $dotenv = new Dotenv();
    $dotenv->load(__DIR__.'/.env');

    $argumentReader = new ArgumentReader($argv); //read arguments
    $file = new File($argumentReader->getFirstArgument(), __DIR__); //creating file object
    $csvReader = new CsvReader($file); // creating csv reader to parse the csv file from arg #1, validate as well
    $csvToOperation = new ReaderToOperation($csvReader); //creating entities from csv
    //creating commissions from operation entities with exchange rate
    $processor = new OperationToCommission($csvToOperation->getOperations());
    $processor->getCalculatedCommissions();
} catch (ConsoleArgumentMissingException|FileDoesNotExist $e) {
    print $e->getMessage()." Check the first argument\n";
    exit;
} catch (CvsFormatNotSupportedException $e) {
    print $e->getMessage()."\n";
    exit;
}
