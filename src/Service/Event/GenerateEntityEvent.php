<?php
namespace App\Service\Event;

use App\Service\Interfaces\GenerateEntityEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class GenerateEntityEvent implements GenerateEntityEventInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }
    /**
     * create new class Event and add arguments to it and then dispatch it
     * @param string $value
     * @param array $parameters
     * @return void
     */
    public function process(string $value, array $parameters): void
    {
        $reflector = new \ReflectionClass($value);
        $event = $reflector->newInstanceArgs($parameters);
        $this->eventDispatcher->dispatch($event, $value::NAME);
    }
}

