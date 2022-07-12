<?php
namespace App\Service\Action;

use App\Event\EmployeeCreatedEvent;
use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\EntityHandlerInterface;
use App\Service\Interfaces\GenerateEntityEventInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CreateEmployeeAction implements ActionInterface
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
    /**
     * @var GenerateEntityEventInterface
     */
    private GenerateEntityEventInterface $generateEntityEvent;


    public function __construct(
        EntityHandlerInterface $entitySerializerHandler,
        NormalizerInterface $youweTeamNormalizer,
        NormalizerInterface $employeeNormalizer,
        GenerateEntityEventInterface $generateEntityEvent
    )
    {
        $this->entitySerializerHandler =  $entitySerializerHandler;
        $this->youweTeamNormalizer =  $youweTeamNormalizer;
        $this->employeeNormalizer =  $employeeNormalizer;
        $this->generateEntityEvent = $generateEntityEvent;
    }
    /**
     * Create Employee and Transform employee entity from normalizer Serializer
     * @param  mixed $inputParam
     * @return array
     */
    public function process($inputParam): array
    {
        $this->generateEntityEvent->process(EmployeeCreatedEvent::class,$inputParam);
        $normalizers=[$this->youweTeamNormalizer,$this->employeeNormalizer];
        $content= $this->entitySerializerHandler->process($inputParam,'save',$normalizers);
        return $content;
    }
}

