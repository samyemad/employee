<?php
namespace App\Service\Action;


use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\EntityHandlerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ShowEmployeeAction implements ActionInterface
{
    /**
     * @var EntityHandlerInterface
     */
    private EntityHandlerInterface $entitySerializerHandler;
    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $youweTeamNormalizer;
    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $employeeNormalizer;

    public function __construct(
        EntityHandlerInterface $entitySerializerHandler,
        NormalizerInterface $youweTeamNormalizer,
        NormalizerInterface $employeeNormalizer
    )
    {
        $this->entitySerializerHandler =  $entitySerializerHandler;
        $this->youweTeamNormalizer =  $youweTeamNormalizer;
        $this->employeeNormalizer =  $employeeNormalizer;
    }
    /**
     * Transform Employee by using custom serializers
     * @param mixed $inputParam
     * @return array
     */
    public function process($inputParam): array
    {
        $normalizers=[$this->youweTeamNormalizer,$this->employeeNormalizer];
        $content= $this->entitySerializerHandler->process($inputParam,'list',$normalizers);
        return $content;
    }
}

