<?php


namespace App\Service\Interfaces;

interface SnakeCaseToCamelCaseHandlerInterface
{
    public function process(string $content): array;
}
