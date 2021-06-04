<?php

namespace Bieronski\DataGrid\Types;


class MoneyType implements DataType
{

    public const PLN = 'PLN';
    public const USD = 'USD';
    public const BHD = 'BHD';
    protected const IS_SORTABLE_NUMERIC = true;
    protected const DEFAULT_PRECISION = [
        'PLN' => 2,     // 1 PLN  = 10^2 groszy
        'USD' => 2,     // 1 USD  = 10^2 cents
        'BHD' => 3      // 1 BHD  = 10^3 fils
    ];

    protected string $currency;
    protected string $thousandsSeparator;
    protected string $decimalSeparator;
    protected bool $showDecimals;
    protected int $precision;


    public function __construct(
        string $currency,
        string $thousandsSeparator = ' ',
        string $decimalSeparator = ',',
        bool $showDecimals = true,
        int $forceCustomPrecision = null
    ) {
        $this->currency = $currency;
        $this->thousandsSeparator = $thousandsSeparator;
        $this->decimalSeparator = $decimalSeparator;
        $this->showDecimals = $showDecimals;
        $this->precision = $forceCustomPrecision ?? self::DEFAULT_PRECISION[$currency];
    }

    public function format(string $value): string
    {
        $formatted = $this->formatNumberAsString($value);
        return $formatted . ' ' . $this->currency;
    }

    protected function formatNumberAsString(string $value): string
    {
        if ($this->showDecimals) {
           return $this->formatWithDecimals($value);
        }
        return $this->formatWithoutDecimals($value);
    }

    protected function formatWithDecimals(string $value): string
    {
        return number_format(
            $value,
            $this->precision,
            $this->decimalSeparator,
            $this->thousandsSeparator,
        );
    }

    protected function formatWithoutDecimals(string $value): string
    {
        // Using number_format with precision = 0 is not working due it's rounding
        // instead cutting decimals off. Therefore int-casting used here.
        return number_format(
            (int)$value,
            0,
            $this->decimalSeparator,
            $this->thousandsSeparator,
        );
    }

    public static function isSortableNumeric(): bool
    {
        return self::IS_SORTABLE_NUMERIC;
    }
}