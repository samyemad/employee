<?php
namespace App\Service\Serializer;

use App\Service\Interfaces\CustomObjectNormalizerInterface;
use Doctrine\Common\Annotations\AnnotationReader;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactory;
use Symfony\Component\Serializer\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class CustomObjectNormalizer implements CustomObjectNormalizerInterface
{
    /**
     * Create Custom ObjectNormalizer by adding many Options when create ObjectNormalizer
     * @return ObjectNormalizer
     */
    public function process():ObjectNormalizer
    {
        $defaultContext = [
            AbstractNormalizer::CIRCULAR_REFERENCE_HANDLER => function ($object, $format, $context) {
                return $object->getIdentifier();
            },
        ];
        $encoders = [new JsonEncoder()];
        $classMetadataFactory = new ClassMetadataFactory(new AnnotationLoader(new AnnotationReader()));
        $metadataAwareNameConverter = new CamelCaseToSnakeCaseNameConverter();
        $objectNormalizer=new ObjectNormalizer($classMetadataFactory,$metadataAwareNameConverter, null, null, null, null, $defaultContext);
        return $objectNormalizer;
    }
}