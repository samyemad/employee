<?php
namespace App\Service\Action;

use App\Event\EmployeeUpdatedEvent;
use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\GenerateEntityEventInterface;

class UpdateEmployeeAction implements ActionInterface
{
    /**
     * @var GenerateEntityEventInterface
     */
    private GenerateEntityEventInterface $generateEntityEvent;

    public function __construct(GenerateEntityEventInterface $generateEntityEvent)
    {
        $this->generateEntityEvent = $generateEntityEvent;
    }
    /**
     * Update Employee Entity by using service for generate event and dispatch it
     * @param mixed $inputParam
     * @return array
     */
    public function process($inputParam): void
    {
        $this->generateEntityEvent->process(EmployeeUpdatedEvent::class,$inputParam);
    }
}

