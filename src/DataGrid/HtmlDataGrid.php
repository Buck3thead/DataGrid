<?php

namespace Bieronski\DataGrid\DataGrid;

use Bieronski\DataGrid\Config\Config;
use Bieronski\DataGrid\State\State;
use Bieronski\DataGrid\Template\Template;


class HtmlDataGrid implements DataGrid
{

    protected Config $config;
    protected Template $template;


    public function __construct(Template $template)
    {
        $this->template = $template;
    }

    public function withConfig(Config $config): DataGrid
    {
        $this->config = $config;
        return $this;
    }

    public function render(array $rows, State $state): string
    {
        try {
            $this->prepareTemplate($rows, $state);
        } catch (\Exception $e) {
            $this->template
                ->bindValue('criticalError', true);
                //bindValue('criticalErrorMessage', $e->getMessage());
        } finally {
            return $this->template->output();
        }
    }

    public function prepareTemplate(array $rows, State $state)
    {
        $sortOnColumn = $state->getOrderBy();
        if ($sortOnColumn <> '') {
            $rows = $this->sortData(
                $rows,
                $sortOnColumn,
                $state->isOrderAsc(),
                $this->config->getColumns()[$sortOnColumn]->getDataType()::isSortableNumeric()
            );
        }

        // Split data to pages
        $paginatedRows = $this->splitData($rows, $state->getRowsPerPage());

        // Calculate
        $rowsToRenderOnCurrentPage = $paginatedRows[$state->getCurrentPage() - 1];   // -1 because array is 0-based
        $columns = $this->config->getColumns();

        // Render
        /* Render labels (headers) */
        $headers = [];
        foreach ($columns as $key => $column) {
            $headers[$key]['align'] = $column->getAlign();
            $headers[$key]['url'] = $this->prepareGetQueryVariableForSorting($state, $key);
            $headers[$key]['content'] = $this->formatHeader($key);
            $headers[$key]['sort'] = '';
            if ($state->getOrderBy() === $key) {
                if ($state->isOrderAsc()) $headers[$key]['sort'] = 'asc';
                if ($state->isOrderDesc()) $headers[$key]['sort'] = 'desc';
            } else {
                $headers[$key]['sort'] = '';
            }
        }

        /* Render data */
        $entireRowError = [];
        $cells = [];
        for ($iRow = 0; $iRow < count($rowsToRenderOnCurrentPage); $iRow++) {

            $errorCountInCurrentRow = 0;
            foreach ($columns as $key => $iColumn) {

                $cells[$iRow][$key]['align'] = $iColumn->getAlign();
                try {
                    $cells[$iRow][$key]['content'] = $iColumn->getDataType()->format($rowsToRenderOnCurrentPage[$iRow][$key]);
                    $cells[$iRow][$key]['error'] = false;
                } catch (\Throwable $e) {
                    $cells[$iRow][$key]['error'] = true;
                    $errorCountInCurrentRow++;
                }
            }
            $entireRowError[$iRow] = ($errorCountInCurrentRow === count($columns));
        }

        /* Render pagination */
        $pagination = [];
        $pagination['shouldRender'] = true; // ToDo
        $urlParameters = [];
        $urlParameters['page'] = $state->getCurrentPage() - 1;
        $pagination['previousButton']['url'] = $this->prepareGetMethodQueryString($urlParameters, []);
        $pagination['previousButton']['isActive'] = ($state->getCurrentPage() > 1);

        for ($iPage = 1; $iPage <= count($paginatedRows); $iPage++) {
            $urlParameters = [];
            $urlParameters['page'] = $iPage;
            $pagination[$iPage]['url'] = $this->prepareGetMethodQueryString($urlParameters, []);
            $pagination[$iPage]['isActive'] = ($iPage <> $state->getCurrentPage());
            $pagination[$iPage]['text'] = $iPage;
            // ToDo skipping 1 2 3 4 5 ... 21
            // ToDo first and last instead Previous Next if multiple pages
        }

        $urlParameters = [];
        $urlParameters['page'] = $state->getCurrentPage() + 1;
        $pagination['nextButton']['isActive'] = ($state->getCurrentPage() < count($paginatedRows));
        $pagination['nextButton']['url'] = $this->prepareGetMethodQueryString($urlParameters, []);

        $this->template
            ->bindValue('criticalError', false)
            ->bindValue('rowsCount', count($rowsToRenderOnCurrentPage) - 1)   // - 1 array is 0-based
            ->bindValue('pagesCount', count($paginatedRows))
            ->bindValue('columnsCount', count($columns))
            ->bindArray('headers', $headers)
            ->bindArray('cells', $cells)
            ->bindArray('shouldRenderRow', $entireRowError)
            ->bindArray('pagination', $pagination);
    }

    protected function prepareGetQueryVariableForSorting(State $state, string $column): string
    {
        $addParameters = [];
        $removeParameters = [];

        // ToDo refactor ifs
        if ($state->getOrderBy() === '') {
            $addParameters['asc'] = 1;
            $addParameters['order'] = $column;
        } elseif ($state->getOrderBy() <> $column) {
            $removeParameters[] = 'asc';
            $removeParameters[] = 'desc';
            $removeParameters[] = 'order';
            $addParameters['asc'] = 1;
            $addParameters['order'] = $column;
        } elseif ($state->isOrderAsc()) {
            $removeParameters[] = 'asc';
            $removeParameters[] = 'desc';
            $addParameters['desc'] = 1;
            $addParameters['order'] = $column;
        } elseif ($state->isOrderDesc()) {
            $removeParameters[] = 'order';
            $removeParameters[] = 'desc';
        }
        return $this->prepareGetMethodQueryString($addParameters, $removeParameters);
    }

    protected function prepareGetMethodQueryString(array $addKeyValues, array $removeKeys): string
    {
        $newParameters = $_GET;
        foreach ($removeKeys as $key) {
            unset($newParameters[$key]);
        }
        foreach ($addKeyValues as $key => $value) {
            $newParameters[$key] = $value;
        }
        return basename($_SERVER['PHP_SELF']).'?'.http_build_query($newParameters);
    }

    protected function sortData(array $rows, string $byColumn, bool $ascending, bool $isNumeric): array
    {
        $sortTextOrInt = $isNumeric ? SORT_NUMERIC : SORT_STRING;
        $sortAscOrDesc = $ascending ? SORT_ASC : SORT_DESC;
        array_multisort(array_column($rows, $byColumn),$sortAscOrDesc, $sortTextOrInt, $rows);
        return $rows;
    }

    protected function splitData(array $rows, int $rowsPerPage): array
    {
        return array_chunk($rows, $rowsPerPage, false);
    }

    protected function formatHeader(string $phrase): string
    {
        return ucfirst($phrase);
    }
}