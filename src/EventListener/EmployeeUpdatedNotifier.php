<?php
namespace App\EventListener;

use App\Event\EmployeeUpdatedEvent;
use App\Repository\EmployeeRepository;
use App\Repository\YouweTeamRepository;

class EmployeeUpdatedNotifier
{
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $employeeRepository;
    /**
     * @var YouweTeamRepository
     */
    private YouweTeamRepository $youweTeamRepository;

    public function __construct(EmployeeRepository $employeeRepository,YouweTeamRepository $youweTeamRepository)
    {
     $this->employeeRepository = $employeeRepository;
     $this->youweTeamRepository = $youweTeamRepository;
    }
    /**
     * notify the EmployeeUpdatedEvent and remove old Youwe Teams that doesn't belong to Employee
     * @param EmployeeUpdatedEvent $event
     * @return void
     */
    public function notify(EmployeeUpdatedEvent $event): void
    {
        $employee=$event->getEmployee();
        foreach ($event->getCurrentYouweTeams() as $currentYouweTeam)
        {
            if (false === $employee->getYouweTeams()->contains($currentYouweTeam))
            {
               $currentYouweTeam->removeEmployee($employee);
               $this->youweTeamRepository->add($currentYouweTeam);
            }
        }
       $this->employeeRepository->add($employee,true);
    }
}

