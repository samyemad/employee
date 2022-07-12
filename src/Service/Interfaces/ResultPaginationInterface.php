<?php

namespace App\Service\Interfaces;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;

interface ResultPaginationInterface
{
    public function get(ServiceEntityRepositoryInterface $repository,string $type,array $options): array;
}
