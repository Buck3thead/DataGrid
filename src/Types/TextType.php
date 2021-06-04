<?php

namespace Bieronski\DataGrid\Types;


class TextType implements DataType
{

    protected const IS_SORTABLE_NUMERIC = false;


    public function format(string $value): string
    {
        $this->preventHtmlTagsInjection($value);
        return $value;
    }

    protected function preventHtmlTagsInjection(string &$value)
    {
        $value = strip_tags($value);
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}