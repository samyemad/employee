<?php

namespace App\Serializer;

use App\Entity\Employee;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;

class EmployeeNormalizer implements NormalizerInterface,SerializerAwareInterface
{
    use SerializerAwareTrait;
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;
    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $normalizer;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }

    public function normalize($employee, string $format = null, array $context = [])
    {
        $this->normalizer->setSerializer($this->serializer);
        $data = $this->normalizer->normalize($employee, $format, $context);
        if(is_array($data))
        {
            $data['_links']['self'] = $this->router->generate('get_employee', [
                'identifier' => $employee->getIdentifier(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof Employee;
    }

    public function setInnerNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
    }
}