<?php


namespace App\Service\Interfaces;

use Symfony\Component\Serializer\SerializerInterface;

interface SerializerNormalizeManagerInterface
{
    public function generate(SerializerInterface $serializer,$entity,string $groupName): array;
}
