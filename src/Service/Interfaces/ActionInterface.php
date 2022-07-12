<?php

namespace App\Service\Interfaces;
use App\Entity\Interfaces\EntityInterface;
interface ActionInterface
{
    /**
     * Perform Action Depend on submit form or any actions
     * @param mixed $inputParam .
     */
    public function process(mixed $inputParam);
}
