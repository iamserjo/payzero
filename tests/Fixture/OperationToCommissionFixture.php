<?php

namespace PayZero\App\Tests\Fixture;

use PayZero\App\Entity\Currency;
use PayZero\App\Entity\Operation;
use PayZero\App\Entity\User;
use PayZero\App\Factory\ClientType;
use PayZero\App\Factory\OperationType;

class OperationToCommissionFixture
{
    public static function getOperationsFromHomeworkFixtures(): array
    {
        return [
            //2014-12-31,4,private,withdraw,1200.00,EUR
            new Operation(
                new \DateTime('2014-12-31'),
                new User(4),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1200.00',
                new Currency('EUR')
            ),
            //2015-01-01,4,private,withdraw,1000.00,EUR
            new Operation(
                new \DateTime('2015-01-01'),
                new User(4),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1000.00',
                new Currency('EUR')
            ),
            //2016-01-05,4,private,withdraw,1000.00,EUR
            new Operation(
                new \DateTime('2016-01-05'),
                new User(4),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1000.00',
                new Currency('EUR')
            ),
            //2016-01-05,1,private,deposit,200.00,EUR
            new Operation(
                new \DateTime('2016-01-05'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('deposit'),
                '200.00',
                new Currency('EUR')
            ),
            //2016-01-06,2,business,withdraw,300.00,EUR
            new Operation(
                new \DateTime('2016-01-06'),
                new User(2),
                ClientType::create('business'),
                OperationType::create('withdraw'),
                '300.00',
                new Currency('EUR')
            ),
            //2016-01-06,1,private,withdraw,30000,JPY
            new Operation(
                new \DateTime('2016-01-06'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '30000',
                new Currency('JPY')
            ),
            //2016-01-07,1,private,withdraw,1000.00,EUR
            new Operation(
                new \DateTime('2016-01-07'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1000.00',
                new Currency('EUR')
            ),
            //2016-01-07,1,private,withdraw,100.00,USD
            new Operation(
                new \DateTime('2016-01-07'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '100.00',
                new Currency('USD')
            ),
            //2016-01-10,1,private,withdraw,100.00,EUR
            new Operation(
                new \DateTime('2016-01-10'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '100.00',
                new Currency('EUR')
            ),
            //2016-01-10,2,business,deposit,10000.00,EUR
            new Operation(
                new \DateTime('2016-01-10'),
                new User(2),
                ClientType::create('business'),
                OperationType::create('deposit'),
                '10000.00',
                new Currency('EUR')
            ),
            //2016-01-10,3,private,withdraw,1000.00,EUR
            new Operation(
                new \DateTime('2016-01-10'),
                new User(3),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1000.00',
                new Currency('EUR')
            ),
            //2016-02-15,1,private,withdraw,300.00,EUR
            new Operation(
                new \DateTime('2016-02-15'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '300.00',
                new Currency('EUR')
            ),
            //2016-02-19,5,private,withdraw,3000000,JPY
            new Operation(
                new \DateTime('2016-02-19'),
                new User(5),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '3000000',
                new Currency('JPY')
            ),
        ];
    }

    public static function getOperationsWhenMoreThanThreeFixture(): array
    {
        return [
            //2015-01-01,1,private,deposit,200.00,EUR
            new Operation(
                new \DateTime('2015-01-01'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('deposit'),
                '200.00',
                new Currency('EUR')
            ),
            //2014-12-31,1,private,withdraw,200.00,EUR
            new Operation(
                new \DateTime('2014-12-31'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '200.00',
                new Currency('EUR')
            ),
            //2015-01-01,1,private,withdraw,100.00,EUR
            new Operation(
                new \DateTime('2015-01-01'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '100.00',
                new Currency('EUR')
            ),
            //2015-01-01,1,private,withdraw,50.00,EUR
            new Operation(
                new \DateTime('2015-01-01'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '50.00',
                new Currency('EUR')
            ),
            //2015-01-02,1,private,withdraw,100.00,EUR
            new Operation(
                new \DateTime('2015-01-02'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '100.00',
                new Currency('EUR')
            ),
            //2015-01-02,1,business,withdraw,2000.00,EUR
            new Operation(
                new \DateTime('2015-01-02'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '2000.00',
                new Currency('EUR')
            ),
        ];
    }

    public static function getOperationsWhenPrecisionZeroFixture(): array
    {
        return [
            //2015-01-01,1,private,deposit,1000,JPY
            new Operation(
                new \DateTime('2015-01-01'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('deposit'),
                '1000',
                new Currency('JPY')
            ),
            //2014-12-31,1,business,withdraw,1000,JPY
            new Operation(
                new \DateTime('2014-12-31'),
                new User(1),
                ClientType::create('business'),
                OperationType::create('withdraw'),
                '1000',
                new Currency('JPY')
            ),
            //2015-01-01,1,private,withdraw,1000,JPY
            new Operation(
                new \DateTime('2015-01-01'),
                new User(1),
                ClientType::create('private'),
                OperationType::create('withdraw'),
                '1000',
                new Currency('JPY')
            ),
        ];
    }
}