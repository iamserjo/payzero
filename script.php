<?php

use PayZero\App\Console\ArgumentReader;
use PayZero\App\File\CsvReader;
use PayZero\App\File\File;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Processor\ReaderToOperation;
use PayZero\App\Service\ExchangeRateClient;
use PayZero\App\Service\ExchangeRateProvider;
use Symfony\Component\Dotenv\Dotenv;

require  __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = new Dotenv();
    $dotenv->usePutenv();
    $dotenv->load(__DIR__.'/.env');

    $argumentReader = new ArgumentReader($argv); //read arguments
    $file = new File($argumentReader->getFirstArgument(), __DIR__); //creating file object
    $csvReader = new CsvReader($file); // creating csv reader to parse the csv file from arg #1, validate as well
    $csvToOperation = new ReaderToOperation($csvReader); //creating entities from csv
    //creating commissions from operation entities with exchange rate
    $processor = new OperationToCommission(
        $csvToOperation->getOperations(),
        new ExchangeRateProvider(new ExchangeRateClient())
    );
    $operations = $processor->getCalculatedOperations();// here is where magic happens
} catch (Throwable $e) {
    print 'ERROR: '.$e->getMessage()."\n";
    exit;
}

foreach ($operations as $operation) { // finally commission output
    print $operation->getCommission()->getCommissionAmount()."\n";
}
