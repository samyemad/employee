<?php

namespace App\Service\Interfaces;


interface LinksPaginationInterface
{
    public function get(string $routeName,int $page,int $size,int $pages): array;
}
