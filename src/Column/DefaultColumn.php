<?php

namespace Bieronski\DataGrid\Column;

use Bieronski\DataGrid\Types\DataType;


class DefaultColumn implements Column
{

    public const ALIGN_LEFT = 'left';
    public const ALIGN_CENTER = 'center';
    public const ALIGN_RIGHT = 'right';

    protected DataType $type;
    protected string $label;
    protected string $align;


    public function withLabel(string $label): Column
    {
        $this->label = $label;
        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function withDataType(DataType $type): Column
    {
        $this->type = $type;
        return $this;
    }

    public function getDataType(): DataType
    {
        return $this->type;
    }

    public function withAlign(string $align): Column
    {
        $this->align = $align;
        return $this;
    }

    public function getAlign(): string
    {
        return $this->align;
    }
}