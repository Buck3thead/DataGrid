<?php

namespace Bieronski\DataGrid\Types;

use Bieronski\DataGrid\Template\Template;


class LinkType implements DataType
{

    protected const IS_SORTABLE_NUMERIC = false;
    public const COLOR_PRIMARY = 'primary';
    public const COLOR_SECONDARY = 'secondary';
    public const COLOR_SUCCESS = 'success';
    public const COLOR_DANGER = 'danger';
    public const COLOR_WARNING = 'warning';
    public const COLOR_INFO = 'info';
    public const COLOR_LIGHT = 'light';
    public const COLOR_DARK = 'dark';
    protected const DEFAULT_BOOTSTRAP_LINK_STYLES = [
        'primary' => 'text-primary',
        'secondary' => 'text-secondary',
        'success' => 'text-success',
        'danger' => 'text-danger',
        'warning' => 'text-warning',
        'info' => 'text-info',
        'light' => 'text-light',
        'dark' => 'text-dark'
    ];
    protected const DEFAULT_BOOTSTRAP_BUTTON_STYLES = [
        'primary' => 'btn btn-primary',
        'secondary' => 'btn btn-secondary',
        'success' => 'btn btn-success',
        'danger' => 'btn btn-danger',
        'warning' => 'btn btn-warning',
        'info' => 'btn btn-info',
        'light' => 'btn btn-light',
        'dark' => 'btn btn-dark'
    ];

    protected Template $template;
    protected bool $asButton;
    protected string $bootstrapColorClass;


    public function __construct(
        Template $template,
        bool $asButton = false,
        string $bootstrapColor = '',
    ) {
        $this->template = $template;
        $this->asButton = $asButton;
        $this->bootstrapColorClass = $this->detectBootstrapColorClass($bootstrapColor);
    }

    public function format(string $value): string
    {
        $render['url'] = $value;
        $render['class'] = $this->bootstrapColorClass;
        return $this->template->bindArray('link', $render)->output();
    }

    protected function detectBootstrapColorClass(string $color): string
    {
        if (($this->asButton) && (array_key_exists($color, self::DEFAULT_BOOTSTRAP_BUTTON_STYLES))) {
            return self::DEFAULT_BOOTSTRAP_BUTTON_STYLES[$color];
        }
        if (array_key_exists($color, self::DEFAULT_BOOTSTRAP_LINK_STYLES)) {
            return self::DEFAULT_BOOTSTRAP_LINK_STYLES[$color];
        }
        return '';
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}