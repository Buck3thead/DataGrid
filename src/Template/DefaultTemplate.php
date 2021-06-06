<?php

namespace Bieronski\DataGrid\Template;


class DefaultTemplate implements Template
{

    protected array $data;
    protected string $templateFile;


    public function __construct(string $templateFile)
    {
        if (!file_exists($templateFile)) {
            // ToDo exception
            echo "Error loading template file ($templateFile).";
        }
        $this->templateFile = $templateFile;
    }

    public function bindValue(string $key, string $value): self
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function bindArray(string $key, array $array): self
    {
        $this->data[$key] = $array;
        return $this;
    }

    public function output(): string
    {
        // To make shorter referring to values in template file
        $data = $this->data;

        // Render data
        ob_start();
        include $this->templateFile;
        $rendered = ob_get_clean();
        return $rendered;
    }
}