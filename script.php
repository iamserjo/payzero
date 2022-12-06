<?php

use PayZero\App\Console\ArgumentReader;
use PayZero\App\File\CsvReader;
use PayZero\App\File\File;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Processor\ReaderToOperation;
use PayZero\App\Service\ExchangeRateClient;
use PayZero\App\Service\ExchangeRateProvider;
use PayZero\App\Validator\ArgumentReader as ArgumentReaderValidator;
use PayZero\App\Validator\CsvReader as CsvReaderValidator;
use PayZero\App\Validator\ExchangeRateClient as ExchangeRateClientValidator;
use Symfony\Component\Dotenv\Dotenv;

require  __DIR__ . '/vendor/autoload.php';

try {
    $dotenv = new Dotenv();
    $dotenv->usePutenv();
    $dotenv->load(__DIR__.'/.env');

    (new ArgumentReaderValidator())->validate($argv);
    $argumentReader = new ArgumentReader($argv); //read arguments

    $file = new File($argumentReader->getFirstArgument(), __DIR__); //creating file object
    $csvReader = new CsvReader(new CsvReaderValidator(), $file); // creating csv reader to parse the csv file from arg #1, validate as well
    $csvToOperation = new ReaderToOperation($csvReader); //creating entities from csv
    //creating commissions from operation entities with exchange rate
    $processor = new OperationToCommission( // this is where magic happens. Operations get filled with commission
        $csvToOperation->getOperations(),
        new ExchangeRateProvider(new ExchangeRateClient(new ExchangeRateClientValidator()))
    );
    foreach ($processor->getCalculatedOperations() as $operation) { // finally commission output
        print $operation->getCommission()->getCommissionAmount()."\n";
    }
    exit(0);
} catch (Throwable $e) {
    print 'ERROR: '.$e->getMessage()."\n";
    exit(1);
}


