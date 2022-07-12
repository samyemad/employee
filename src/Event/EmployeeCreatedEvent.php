<?php
namespace App\Event;
use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Employee;

class EmployeeCreatedEvent extends Event
{
    public const NAME = 'app.employee.created';
    /**
     * @var Employee
     */
    protected Employee $employee;

    public function __construct(Employee $employee)
    {
        $this->employee = $employee;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }
}

