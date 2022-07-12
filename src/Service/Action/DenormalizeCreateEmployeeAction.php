<?php
namespace App\Service\Action;

use App\Entity\Employee;
use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\PrepareErrorsInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DenormalizeCreateEmployeeAction implements ActionInterface
{
    /**
     * @var SerializerInterface
     */
    private SerializerInterface $serializer;
    /**
     * @var PrepareErrorsInterface
     */
    private PrepareErrorsInterface $prepareValidationErrors;

    public function __construct(
        SerializerInterface $serializer,
        PrepareErrorsInterface $prepareValidationErrors
    )
    {
        $this->serializer =  $serializer;
        $this->prepareValidationErrors = $prepareValidationErrors;

    }
    /**
     * Denormalize Employee based on Employee Entity and return object of employee Entity
     * @param mixed $inputParam
     * @return array|Employee
     */
    public function process($inputParam)
    {
        try
        {
            $result = $this->serializer->denormalize($inputParam, Employee::class, 'json',['groups' => 'save']);
        }
        catch (\Exception $e)
        {
            $result=$this->prepareValidationErrors->process([$e->getMessage()]);
        }
        return $result;
    }
}

