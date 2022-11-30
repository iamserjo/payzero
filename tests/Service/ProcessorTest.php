<?php

declare(strict_types=1);

namespace PayZero\App\Tests\Service;

use PayZero\App\Entity\Currency;
use PayZero\App\Entity\Operation;
use PayZero\App\Entity\User;
use PayZero\App\Factory\ClientType;
use PayZero\App\Factory\OperationType;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Tests\FakeService\ExchangeRate;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    /**
     * @var Operation[]
     */
    public static array $operations = [];

    public static function setUpBeforeClass(): void
    {
        $operations = [
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

        $operationToCommission = new OperationToCommission($operations, new ExchangeRate());
        self::$operations = $operationToCommission->getCalculatedCommissions();
    }

    public function testCount()
    {
        $this->assertCount(
            13,
            self::$operations
        );
    }

    /**
     * @param int $index
     * @param string $expectation
     *
     * @dataProvider dataProviderForAddTesting
     * @depends testCount
     */
    public function testAdd(int $index, string $expectation)
    {
        $this->assertEquals(
            $expectation,
            self::$operations[$index]->getCommission()->getCommissionAmount()
        );
    }

    public function dataProviderForAddTesting(): array
    {
        return [
            '2014-12-31,4,private,withdraw,1200.00,EUR' => [0, '0.60'],
            '2015-01-01,4,private,withdraw,1000.00,EUR' => [1, '3.00'],
            '2016-01-05,4,private,withdraw,1000.00,EUR' => [2, '0.00'],
            '2016-01-05,1,private,deposit,200.00,EUR' => [3, '0.06'],
            '2016-01-06,2,business,withdraw,300.00,EUR' => [4, '1.50'],
        ];
    }
}
