<?php

namespace Bieronski\DataGrid\Types;


class RawType implements DataType
{

    protected const IS_SORTABLE_NUMERIC = false;


    public function format(string $value): string
    {
        return $value;
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}