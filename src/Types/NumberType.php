<?php

namespace Bieronski\DataGrid\Types;


class NumberType implements DataType
{

    public const ROUND_REGULAR = 0;
    public const ROUND_ALWAYS_UP = 1;
    public const ROUND_ALWAYS_DOWN = 2;
    protected const IS_SORTABLE_NUMERIC = true;
    protected const ROUND_METHOD = [
        0 => 'roundRegular',
        1 => 'roundAlwaysUp',
        2 => 'roundAlwaysDown'
    ];

    protected string $thousandsSeparator;
    protected string $decimalSeparator;
    protected int $precision;
    protected int $roundMethod;
    protected bool $forceTrailingZeros;


    public function __construct(
        string $thousandsSeparator = ' ',
        string $decimalSeparator = ',',
        int $precision = 2,
        int $roundMethod = 0,
        bool $forceTrailingZeros = true
    ) {
        $this->thousandsSeparator = $thousandsSeparator;
        $this->decimalSeparator = $decimalSeparator;
        $this->precision = $precision;
        $this->roundMethod = $roundMethod;
        $this->forceTrailingZeros = $forceTrailingZeros;
    }

    public function format(string $value): string
    {
        if (!(is_numeric($value))) {
            throw new \Exception("Not numeric value given.");
        }
        $rounded = $this->round($value);
        $formatted = number_format(
            $rounded,
            $this->precision,
            $this->decimalSeparator,
            $this->thousandsSeparator,
        );
        if (!($this->forceTrailingZeros)) {
            return $this->fixTrailingZeros($formatted);
        }
        return $formatted;
    }

    protected function roundRegular(string $value): string
    {
        return round($value, $this->precision);
    }

    protected function round(string $value): string
    {
        return call_user_func(
            array($this, self::ROUND_METHOD[$this->roundMethod]),
            $value
        );
    }

    protected function roundAlwaysUp(string $value): string
    {
        // Due performance reason build string instead power of ten 10^x
        $tempNumber = (int) str_pad('1', $this->precision + 1, '0');
        return ceil($value * $tempNumber) / $tempNumber;
    }

    protected function roundAlwaysDown(string $value): string
    {
        $tempNumber = (int) str_pad('1', $this->precision + 1, '0');
        return floor($value * $tempNumber) / $tempNumber;
    }

    protected function fixTrailingZeros(string $value): string
    {
        if (false !== strpos($value, '.')) {
            $value = rtrim(rtrim($value, '0'), '.');
        }
        return $value;
    }

    public static function isSortableNumeric(): bool
    {
       return  self::IS_SORTABLE_NUMERIC;
    }
}