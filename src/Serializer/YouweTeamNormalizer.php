<?php

namespace App\Serializer;

use App\Entity\YouweTeam;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;

class YouweTeamNormalizer implements NormalizerInterface,SerializerAwareInterface
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
    public function normalize($youweTeam, string $format = null, array $context = [])
    {
        $this->normalizer->setSerializer($this->serializer);
        $data = $this->normalizer->normalize($youweTeam, $format, $context);
        if(is_array($data))
        {
            if(empty($data['employees']))
            {
             unset($data['employees']);
            }
            $data['_links']['self'] = $this->router->generate('get_youwe_team', [
                'identifier' => $youweTeam->getIdentifier(),
            ], UrlGeneratorInterface::ABSOLUTE_URL);
        }
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof YouweTeam;
    }

    public function setInnerNormalizer(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;

    }
}