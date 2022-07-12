<?php

namespace App\Service\Interfaces;

interface GenerateEntityEventInterface
{
    public function process(string $value,array $parameters): void;
}
