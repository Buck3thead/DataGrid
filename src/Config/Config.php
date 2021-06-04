<?php

namespace Bieronski\DataGrid\Config;

use Bieronski\DataGrid\Column\Column;


interface Config
{
    /**
     * Dodaje nową kolumnę do DataGrid.
     */
    public function addColumn(string $key, Column $column): Config;

    /**
     * Zwraca wszystkie kolumny dla danego DataGrid.
     * @return Column[]
     */
    public function getColumns(): array;
}