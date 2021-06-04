<?php

namespace Bieronski\DataGrid\State;


class HttpState implements State
{

    protected int $currentPage;
    protected string $orderBy;
    protected string $isOrderAsc;
    protected string $isOrderDesc;
    protected int $rowsPerPage;

    // I don't know which design pattern is suggested in example
    //    $state = HttpState::create();
    // instead just $state = new HttpState();
    public function __construct(
        int $currentPage,
        string $orderBy ,
        bool $isOrderAsc,
        bool $isOrderDesc,
        int $rowsPerPage
    ) {
        $this->currentPage = $currentPage;
        $this->orderBy = $orderBy;
        $this->isOrderAsc = $isOrderAsc;
        $this->isOrderDesc = $isOrderDesc;
        $this->rowsPerPage = $rowsPerPage;
    }

    public static function create(): self
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $currentPage = (!empty($_GET['page'])) ? $_GET['page'] : 1;
            $orderBy = (!empty($_GET['order'])) ? $_GET['order'] : '';
            $asc = (!empty($_GET['asc'])) ? $_GET['asc'] : false;
            $desc = (!empty($_GET['desc'])) ? $_GET['desc'] : false;
            $rows = (!empty($_GET['rows'])) ? $_GET['rows'] : 9;
            return new HttpState($currentPage, $orderBy, $asc, $desc, $rows);
        }
        //  return new state with default arguments
        return new HttpState(1, '', false, false, 9);
    }

    //ToDo setGetVariableNames/ getNames

    public function getCurrentPage(): int
    {
        return $this->currentPage;
    }

    public function getOrderBy(): string
    {
        return $this->orderBy;
    }

    public function isOrderDesc(): bool
    {
        return $this->isOrderDesc;
    }

    public function isOrderAsc(): bool
    {
        return $this->isOrderAsc;
    }

    public function getRowsPerPage(): int
    {
        return $this->rowsPerPage;
    }
}