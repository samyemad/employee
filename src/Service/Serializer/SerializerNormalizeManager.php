<?php
namespace App\Service\Serializer;

use App\Entity\Interfaces\EntityInterface;
use App\Service\Interfaces\SerializerNormalizeManagerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class SerializerNormalizeManager implements SerializerNormalizeManagerInterface
{
    /**
     * Passing Many options to serializer before normalize it
     * @param SerializerInterface $serializer
     * @param array|EntityInterface $entity
     * @param string $groupName
     * @return array
     */
    public function generate(SerializerInterface $serializer,$entity,string $groupName): array
    {
        $defaultContext = [
            AbstractObjectNormalizer::SKIP_NULL_VALUES => true,'groups' => $groupName
        ];
        $data=$serializer->normalize($entity,null,$defaultContext);
        return $data;
    }
}