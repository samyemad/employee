<?php
namespace App\Form\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class AddIdentifierSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            FormEvents::PRE_SET_DATA => 'onPreSetEmployee',
        ];
    }

    public function onPreSetEmployee(FormEvent $event): void
    {
        $employee = $event->getData();
        $form = $event->getForm();
        if(!$employee->getId())
        {
            $form->add('identifier', TextType::class, [
                'required' => true,
            ]);
        }

    }
}