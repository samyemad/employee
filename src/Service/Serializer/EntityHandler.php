<?php
namespace App\Service\Serializer;

use Symfony\Component\DependencyInjection\ServiceLocator;
use App\Service\Interfaces\EntityHandlerInterface;

class EntityHandler implements EntityHandlerInterface
{
    /**
     * @var ServiceLocator
     */
    private ServiceLocator $locator;

    public function __construct(ServiceLocator $locator)
    {
        $this->locator = $locator;
    }
    /**
     * Handle Entity and make new Serializer and add many normalizers to it
     * @param array $result
     * @param string $groupName
     * @param array $normalizers
     * @return array
     */
    public function process($result,string $groupName,array $normalizers):array
    {
        $serialize=$this->locator->get('handler_serializer');
        $serializerResult=$serialize->generate($normalizers);
        $normalizer=$this->locator->get('handler_serializer_normalizer');
        $data=$normalizer->generate($serializerResult,$result,$groupName);
        return $data;
    }
}