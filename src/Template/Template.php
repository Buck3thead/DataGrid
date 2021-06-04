<?php

namespace Bieronski\DataGrid\Template;


interface Template
{

    /**
     * Assign value to Template class which will be used by output method.
     * The key is used to easier referring to this value while rendering.
     *
     */
    public function bindValue(string $key, string $value): Template;

    /**
     * The same like bindValue method but binding associative array.
     * The key is required to make able binding multiple arrays to differ them.
     */
    public function bindArray(string $key, array $array): Template;

    /**
     * Render collection of given values by binding methods.
     */
    public function output(): string;
}