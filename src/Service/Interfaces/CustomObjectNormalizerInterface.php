<?php


namespace App\Service\Interfaces;

use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;


interface CustomObjectNormalizerInterface
{
    public function process(): ObjectNormalizer;
}
