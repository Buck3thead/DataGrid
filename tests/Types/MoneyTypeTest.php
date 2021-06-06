<?php

namespace Bieronski\DataGrid\Tests\Types;

use Bieronski\DataGrid\Types\DataType;
use Bieronski\DataGrid\Types\MoneyType;
use PHPUnit\Framework\TestCase;


final class MoneyTypeTest extends TestCase
{

    public function testShouldImplementProperInterface()
    {
        // Given
        $moneyType = new MoneyType(MoneyType::BHD);

        // Then
        $this->assertInstanceOf(DataType::class, $moneyType);
    }
    
    public function testShouldFormatValueWithDefaultDecimals()
    {
        // Given
        $moneyType = new MoneyType(MoneyType::BHD);
    
        // When
        $formatted = $moneyType->format(1000.12345);
    
        // Then
        $this->assertSame('1 000,123 BHD', $formatted);
    }

    public function testShouldFormatValueWithCustomSeparatorsAndDecimals()
    {
        // Given
        $moneyType = new MoneyType(MoneyType::USD, ',','.', true, 4);

        // When
        $formatted = $moneyType->format(1000.123);

        // Then
        $this->assertSame('1,000.1230 USD', $formatted);
    }

    public function testShouldFormatValueWithoutDecimals()
    {
        // Given
        $moneyType = new MoneyType(MoneyType::PLN, ' ', '', false);

        // When
        $formatted = $moneyType->format(1000.123);

        // Then
        $this->assertSame('1 000 PLN', $formatted);
    }
}