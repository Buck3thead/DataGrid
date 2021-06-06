<?php

namespace Types;

use Bieronski\DataGrid\Types\DataType;
use Bieronski\DataGrid\Types\TextType;
use PHPUnit\Framework\TestCase;


final class TextTypeTest extends TestCase
{

    public function testShouldImplementProperInterface()
    {
        // Given
        $textType = new TextType();

        // Then
        $this->assertInstanceOf(DataType::class, $textType);
    }

    public function testShouldRemoveHtmlTags()
    {
        // Given
        $textType = new TextType();

        // When
        $result = $textType->format('<br>DummyText</br>');

        // Then
        $this->assertSame('DummyText', $result);
    }
}