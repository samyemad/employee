<?php


namespace App\Service\Interfaces;

interface EntityHandlerInterface
{
    public function process(array $result,string $groupName ,array $normalizers): array;
}
