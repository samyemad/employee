<?php
namespace App\EventListener;

use App\Event\EmployeeCreatedEvent;
use App\Repository\EmployeeRepository;

class EmployeeCreatedNotifier
{
    /**
     * @var EmployeeRepository
     */
    private EmployeeRepository $repository;

    public function __construct(EmployeeRepository $repository)
    {
     $this->repository = $repository;
    }
    /**
     * notify the EmployeeCreatedEvent and add employee with flush to employee repository
     * @param EmployeeCreatedEvent $event
     * @return void
     */
    public function notify(EmployeeCreatedEvent $event): void
    {
       $employee=$event->getEmployee();
       $this->repository->add($employee,true);
    }
}

