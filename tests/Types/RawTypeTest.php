<?php

namespace Types;

use Bieronski\DataGrid\Types\DataType;
use Bieronski\DataGrid\Types\RawType;
use PHPUnit\Framework\TestCase;


final class RawTypeTest extends TestCase
{

    public function testShouldImplementProperInterface()
    {
        // Given
        $rawType = new RawType();

        // Then
        $this->assertInstanceOf(DataType::class, $rawType);
    }

    public function testShouldRemoveHtmlTags()
    {
        // Given
        $rawType = new RawType();

        // When
        $result = $rawType->format('<br>DummyText</br>');

        // Then
        $this->assertSame('<br>DummyText</br>', $result);
    }
}