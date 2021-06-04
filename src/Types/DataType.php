<?php

namespace Bieronski\DataGrid\Types;


interface DataType
{
    /**
     * Formatuje dane dla danego typu.
     */
    public function format(string $value): string;

    /**
     * Sprawdza czy dany typ sortuje się jak stringi czy jak liczby.
     */
    public static function isSortableNumeric(): bool;
}