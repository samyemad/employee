<?php

namespace App\Service\Interfaces;

use Symfony\Component\Form\FormInterface;

interface ProcessFormErrorsInterface
{
    public function process(FormInterface $form): array;
}
