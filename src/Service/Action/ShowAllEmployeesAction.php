<?php
namespace App\Service\Action;

use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\EntityHandlerInterface;
use App\Service\Interfaces\PrepareResultInterface;
use phpDocumentor\Reflection\Types\Nullable;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\EmployeeRepository;

class ShowAllEmployeesAction implements ActionInterface
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
     * @var PrepareResultInterface
     */
    private PrepareResultInterface $prepareResult;
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    public function __construct(
        EntityHandlerInterface $entitySerializerHandler,
        NormalizerInterface $youweTeamNormalizer,
        NormalizerInterface $employeeNormalizer,
        PrepareResultInterface $prepareResult,
        EmployeeRepository $employeeRepository
    )
    {
        $this->entitySerializerHandler =  $entitySerializerHandler;
        $this->youweTeamNormalizer =  $youweTeamNormalizer;
        $this->employeeNormalizer =  $employeeNormalizer;
        $this->prepareResult = $prepareResult;
        $this->employeeRepository = $employeeRepository;
    }
    /**
     * Show All Employees and transform it from normalizer Serializer
     * @param mixed $inputParam
     * @return array
     */
    public function process($inputParam): array
    {
        $allEmployees=$this->prepareResult->get($this->employeeRepository);
        $normalizers=[$this->youweTeamNormalizer,$this->employeeNormalizer];
        $content= $this->entitySerializerHandler->process($allEmployees,'list',$normalizers);
        return $content;
    }
}

