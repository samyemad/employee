<?php
namespace App\Event;
use Symfony\Contracts\EventDispatcher\Event;
use App\Entity\Employee;
use Doctrine\ORM\PersistentCollection;

class EmployeeUpdatedEvent extends Event
{
    public const NAME = 'app.employee.updated';
    /**
     * @var Employee
     */
    protected Employee $employee;
    /**
     * @var PersistentCollection
     */
    protected PersistentCollection $currentYouweTeams;

    public function __construct(Employee $employee,PersistentCollection $currentYouweTeams)
    {
        $this->employee = $employee;
        $this->currentYouweTeams = $currentYouweTeams;
    }

    public function getEmployee(): Employee
    {
        return $this->employee;
    }

    public function getCurrentYouweTeams():PersistentCollection
    {
        return  $this->currentYouweTeams;

    }
}

