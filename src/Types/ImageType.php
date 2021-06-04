<?php

namespace Bieronski\DataGrid\Types;

use Bieronski\DataGrid\Template\Template;


class ImageType implements DataType
{

    protected const IS_SORTABLE_NUMERIC = false;

    protected Template $template;
    protected int $width;
    protected int $height;


    public function __construct(Template $template, int $width = 16, int $height = 16)
    {
        $this->template = $template;
        $this->width = $width;
        $this->height = $height;
    }

    public function format(string $value): string
    {
        $render['src'] = $value;
        $render['width'] = $this->width;
        $render['height'] = $this->height;
        return $this->template->bindArray('img', $render)->output();
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}