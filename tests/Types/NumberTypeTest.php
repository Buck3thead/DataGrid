<?php

namespace Types;

use Bieronski\DataGrid\Types\DataType;
use Bieronski\DataGrid\Types\NumberType;
use PHPUnit\Framework\TestCase;


final class NumberTypeTest extends TestCase
{

    public function testShouldImplementProperInterface()
    {
        // Given
        $numberType = new NumberType();

        // Then
        $this->assertInstanceOf(DataType::class, $numberType);
    }

    public function testShouldProvideProperDefaultNumberFormatting()
    {
        // ToDo: verify if use something like getters or reflection
        //       to get constants (separators) to build a result
        //       instead of hard-coding assertion

        // Given
        $numberType = new NumberType();

        // When
        $result = $numberType->format('12345678.9000');

        // Then
        $this->assertSame('12 345 678,90', $result);
    }

    public function testShouldProvideAbilityToChangeThousandsAndDecimalSeparator()
    {
        // Given
        $numberType = new NumberType('-', ':');

        // When
        $result = $numberType->format('12345678.9000');

        // Then
        $this->assertSame('12-345-678:90', $result);
    }

    public function testShouldRoundValueMathWayWhenRoundRegularFlagGiven()
    {
        // Given
        $numberType = new NumberType('','.', 2, NumberType::ROUND_REGULAR);

        // When
        $result1 = $numberType->format('100.955');
        $result2 = $numberType->format('100.954');

        // Then
        $this->assertSame('100.96', $result1);
        $this->assertSame('100.95', $result2);
    }

    public function testShouldRoundValueDownWhenAlwaysDownFlagGiven()
    {
        // Given
        $numberType = new NumberType('','.', 2, NumberType::ROUND_ALWAYS_DOWN);

        // When
        $result = $numberType->format('100.955');

        // Then
        $this->assertSame('100.95', $result);
    }

    public function testShouldRoundValueUpWhenAlwaysUpFlagGiven()
    {
        // Given
        $numberType = new NumberType('','.', 2, NumberType::ROUND_ALWAYS_UP);

        // When
        $result = $numberType->format('100.955');

        // Then
        $this->assertSame('100.96', $result);
    }

    public function testShouldKeepOrHideTrailingZeros()
    {
        // Given
        $numberTypeWithShownZeros = new NumberType('','.', 3, NumberType::ROUND_REGULAR, true);
        $numberTypeWithHiddenZeros = new NumberType('','.', 3, NumberType::ROUND_REGULAR, false);

        // When
        $resultShown = $numberTypeWithShownZeros->format('100.900');
        $resultHidden = $numberTypeWithHiddenZeros->format('100.900');

        // Then
        $this->assertSame('100.900', $resultShown);
        $this->assertSame('100.9', $resultHidden);
    }
}