<?php

namespace Bieronski\DataGrid\Config;

use Bieronski\DataGrid\Column\Column;
use Bieronski\DataGrid\Column\DefaultColumn;
use Bieronski\DataGrid\Template\DefaultTemplate;
use Bieronski\DataGrid\Types\ImageType;
use Bieronski\DataGrid\Types\LinkType;
use Bieronski\DataGrid\Types\MoneyType;
use Bieronski\DataGrid\Types\NumberType;
use Bieronski\DataGrid\Types\TextType;


class DefaultConfig implements Config
{

    /* @var $columns Column[] */
    protected array $columns = [];
    protected array $templatesPaths;


    public function __construct(array $templatesPaths)
    {
        $this->templatesPaths = $templatesPaths;
    }

    public function addColumn(string $key, Column $column): Config
    {
        $this->columns[$key] = $column;
        return $this;
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    public function addIntColumn(string $key): self
    {
        $column = (new DefaultColumn())
            ->withDataType(new NumberType('','',0))
            ->withAlign(DefaultColumn::ALIGN_RIGHT)
            ->withLabel($key);
        $this->addColumn($key, $column);
        return $this;
    }

    public function addTextColumn(string $key): self
    {
        $column = (new DefaultColumn())
            ->withDataType(new TextType())
            ->withAlign(DefaultColumn::ALIGN_LEFT)
            ->withLabel($key);
        $this->addColumn($key, $column);
        return $this;
    }

    public function addCurrencyColumn(string $key, string $currency): self
    {
        $column = (new DefaultColumn())
            ->withDataType(new MoneyType($currency))
            ->withAlign(DefaultColumn::ALIGN_RIGHT)
            ->withLabel($key);
        $this->addColumn($key, $column);
        return $this;
    }

    public function addLinkColumn(string $key, bool $asButton = false): self
    {
        $templateFileKey = $asButton ? 'button' : 'regular';
        $template = new DefaultTemplate(__DIR__ . $this->templatesPaths['types']['link'][$templateFileKey]);
        $column = (new DefaultColumn())
            ->withDataType(new LinkType($template, $asButton, LinkType::COLOR_PRIMARY))
            ->withAlign(DefaultColumn::ALIGN_LEFT)
            ->withLabel($key);
        $this->addColumn($key, $column);
        return $this;
    }

    public function addPictureColumn(string $key): self
    {
        $template = new DefaultTemplate(__DIR__ . $this->templatesPaths['types']['image']);
        $column = (new DefaultColumn())
            ->withDataType(new ImageType($template, 16, 16))
            ->withAlign(DefaultColumn::ALIGN_LEFT)
            ->withLabel($key);
        $this->addColumn($key, $column);
        return $this;
    }
}