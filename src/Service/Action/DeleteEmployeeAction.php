<?php
namespace App\Service\Action;


use App\Entity\Employee;
use App\Repository\EmployeeRepository;
use App\Service\Interfaces\ActionInterface;

class DeleteEmployeeAction implements ActionInterface
{
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository = $employeeRepository;
    }

    /**
     * Remove Employee Entity by using employeeRepository
     * @param mixed $inputParam
     * @return void
     */
    public function process($inputParam): void
    {
        $this->employeeRepository->remove($inputParam,true);
    }
}

