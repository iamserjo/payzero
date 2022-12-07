<?php

declare(strict_types=1);

namespace PayZero\App\Tests\Service;

use PayZero\App\Entity\Currency;
use PayZero\App\Entity\Operation;
use PayZero\App\Processor\OperationToCommission;
use PayZero\App\Service\ExchangeRateProvider;
use PayZero\App\Tests\Fixture\OperationToCommissionFixture;
use PHPUnit\Framework\TestCase;

class OperationToCommissionTest extends TestCase
{
    private static bool $initialized = false;
    /**
     * @var Operation[]
     */
    private static array $operationsFromHomework = [];

    /**
     * @var Operation[]
     */
    private static array $operationsWhenMoreThanThree = [];

    /**
     * @var Operation[]
     */
    private static array $operationsWhenPrecisionZero = [];

    public function setUp(): void
    {
        parent::setUp();
        if (!self::$initialized) {
            self::$initialized = true;
            $this->initOperationsFromHomework();
            $this->initOperationsWhenMoreThanThree();
            $this->initOperationsWhenPrecisionZero();
        }
    }

    private function getExchangeRateProviderMock()
    {
        $mock = $this->getMockBuilder(ExchangeRateProvider::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mock
            ->method('getExchangeRate')
            ->will($this->returnCallback(function ($currency) {
                return match ($currency->getCurrencyCode()) { //old exchange rate values from the homework
                    'EUR' => '1',
                    'USD' => '1.1497',
                    'JPY' => '129.53',
                };
            }));

        $mock
            ->method('getBaseCurrency')
            ->will($this->returnValue(new Currency('EUR')));

        return $mock;
    }

    private function initOperationsFromHomework(): void
    {
        $operations = OperationToCommissionFixture::getOperationsFromHomeworkFixtures();
        $operationToCommission = new OperationToCommission($operations, $this->getExchangeRateProviderMock());
        foreach ($operationToCommission->getCalculatedOperations() as $operation) {
            self::$operationsFromHomework[] = $operation;
        }
    }

    private function initOperationsWhenMoreThanThree(): void
    {
        $operations = OperationToCommissionFixture::getOperationsWhenMoreThanThreeFixture();
        $operationToCommission = new OperationToCommission($operations, $this->getExchangeRateProviderMock());
        foreach ($operationToCommission->getCalculatedOperations() as $operation) {
            self::$operationsWhenMoreThanThree[] = $operation;
        }
    }

    private function initOperationsWhenPrecisionZero(): void
    {
        $operations = OperationToCommissionFixture::getOperationsWhenPrecisionZeroFixture();
        $operationToCommission = new OperationToCommission($operations, $this->getExchangeRateProviderMock());
        foreach ($operationToCommission->getCalculatedOperations() as $operation) {
            self::$operationsWhenPrecisionZero[] = $operation;
        }
    }

    public function testCountForHomework(): void
    {
        $this->assertCount(
            13,
            self::$operationsFromHomework
        );
    }

    public function testCountWhenMoreThanThree(): void
    {
        $this->assertCount(
            6,
            self::$operationsWhenMoreThanThree
        );
    }

    public function testCountWhenPrecisionZero(): void
    {
        $this->assertCount(
            3,
            self::$operationsWhenPrecisionZero
        );
    }

    /**
     * @param int $index
     * @param string $expectation
     *
     * @dataProvider dataProviderForOperationToCommissionFromHomework
     * @depends      testCountForHomework
     */
    public function testOperationsToCommissionFromHomework(int $index, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            self::$operationsFromHomework[$index]->getCommission()->getCommissionAmount()
        );
    }

    /**
     * @param int $index
     * @param string $expectation
     *
     * @dataProvider dataProviderForOperationToCommissionWhenMoreThanThree
     * @depends      testCountWhenMoreThanThree
     */
    public function testOperationsToCommissionWhenMoreThanThree(int $index, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            self::$operationsWhenMoreThanThree[$index]->getCommission()->getCommissionAmount()
        );
    }

    /**
     * @param int $index
     * @param string $expectation
     *
     * @dataProvider dataProviderForOperationToCommissionWhenPrecisionZero
     * @depends      testCountWhenPrecisionZero
     */
    public function testOperationsToCommissionWhenPrecisionZero(int $index, string $expectation): void
    {
        $this->assertEquals(
            $expectation,
            self::$operationsWhenPrecisionZero[$index]->getCommission()->getCommissionAmount()
        );
    }

    private function dataProviderForOperationToCommissionWhenMoreThanThree(): array
    {
        return [
            '2015-01-01,1,private,deposit,200,EUR' => [0, '0.06'],
            '2014-12-31,1,private,withdraw,200.00,EUR' => [1, '0.00'],
            '2015-01-01,1,private,withdraw,100.00,EUR' => [2, '0.00'],
            '2015-01-01,1,private,withdraw,50.00,EUR' => [3, '0.00'],
            '2015-01-02,1,business,withdraw,100.00,EUR' => [4, '0.30'],
            '2015-01-02,1,business,withdraw,2000.00,EUR' => [5, '6.00'],
        ];
    }

    private function dataProviderForOperationToCommissionFromHomework(): array
    {
        return [
            '2014-12-31,4,private,withdraw,1200.00,EUR' => [0, '0.60'],
            '2015-01-01,4,private,withdraw,1000.00,EUR' => [1, '3.00'],
            '2016-01-05,4,private,withdraw,1000.00,EUR' => [2, '0.00'],
            '2016-01-05,1,private,deposit,200.00,EUR' => [3, '0.06'],
            '2016-01-06,2,business,withdraw,300.00,EUR' => [4, '1.50'],
            '2016-01-06,1,private,withdraw,30000,JPY' => [5, '0'],
            '2016-01-07,1,private,withdraw,1000.00,EUR' => [6, '0.70'],
            '2016-01-07,1,private,withdraw,100.00,USD' => [7, '0.30'],
            '2016-01-10,1,private,withdraw,100.00,EUR' => [8, '0.30'],
            '2016-01-10,2,business,deposit,10000.00,EUR' => [9, '3.00'],
            '2016-01-10,3,private,withdraw,1000.00,EUR' => [10, '0.00'],
            '2016-02-15,1,private,withdraw,300.00,EUR' => [11, '0.00'],
            '2016-02-19,5,private,withdraw,3000000,JPY' => [12, '8612'],
        ];
    }

    private function dataProviderForOperationToCommissionWhenPrecisionZero(): array
    {
        return [
            '2015-01-01,1,private,deposit,1000,JPY' => [0, '1'],
            '2014-12-31,1,business,withdraw,1000,JPY' => [1, '5'],
            '2015-01-01,1,private,withdraw,1000,JPY' => [2, '0'],
        ];
    }
}
