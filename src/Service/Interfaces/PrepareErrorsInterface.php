<?php

namespace App\Service\Interfaces;

interface PrepareErrorsInterface
{
    public function process(array $errors): array;
}
