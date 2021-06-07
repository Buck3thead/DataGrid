<?php

namespace Bieronski\DataGrid\Processor;


class NonBreakingSpacesArrayTextProcessor implements ArrayTextProcessor
{

    public static function process(array $strings): array
    {
        array_walk(
            $strings,
            function(&$string) {
                $string = str_replace(" ", "&nbsp;", $string);
            }
        );
        return $strings;
    }
}