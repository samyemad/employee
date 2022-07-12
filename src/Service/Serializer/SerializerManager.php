<?php
namespace App\Service\Serializer;

use App\Service\Interfaces\CustomObjectNormalizerInterface;
use App\Service\Interfaces\SerializerManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;



class SerializerManager implements SerializerManagerInterface
{
    /**
     * @var CustomObjectNormalizerInterface
     */
    private CustomObjectNormalizerInterface $customObjectNormalizer;

    public function __construct(CustomObjectNormalizerInterface $customObjectNormalizer)
    {
      $this->customObjectNormalizer = $customObjectNormalizer;
    }
    /**
     * Passing Normalizers to Serializer and then create new Instance of it
     * @param array $normalizers
     * @return SerializerInterface
     */
    public function generate(array $normalizers): SerializerInterface
    {
        $objectNormalizer=$this->customObjectNormalizer->process();
        foreach($normalizers as $normalizer)
        {
            $normalizer->setInnerNormalizer($objectNormalizer);
        }
        array_push($normalizers,new DateTimeNormalizer());
        $serializer = new Serializer($normalizers);
        return $serializer;
    }
}