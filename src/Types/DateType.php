<?php

namespace Bieronski\DataGrid\Types;


class DateType implements DataType
{

    protected const IS_SORTABLE_NUMERIC = true;
    protected string $format;


    public function __construct(string $format)
    {
        $this->format = $format;
    }

    public function format(string $value): string
    {
        return date_format(date_create($value), $this->format);
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}