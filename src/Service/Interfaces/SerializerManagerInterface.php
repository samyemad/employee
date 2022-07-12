<?php


namespace App\Service\Interfaces;

use Symfony\Component\Serializer\SerializerInterface;

interface SerializerManagerInterface
{
    public function generate(array $normalizers): SerializerInterface;
}
