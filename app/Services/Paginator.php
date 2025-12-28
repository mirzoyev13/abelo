<?php

namespace App\Services;

class Paginator
{
    public int $currentPage;
    public int $perPage;
    public int $total;
    public int $pages;

    public function __construct(int $total, int $currentPage, int $perPage = 5)
    {
        $this->total = $total;
        $this->perPage = $perPage;
        $this->pages = (int)ceil($total / $perPage);
        $this->currentPage = max(1, min($currentPage, $this->pages));
    }

    public function offset(): int
    {
        return ($this->currentPage - 1) * $this->perPage;
    }
}
