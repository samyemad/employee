<?php
declare(strict_types=1);

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    /**
     * add Roles to User when success  Authentication JWT
     * @param AuthenticationSuccessEvent $event
     * @return void
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();
        if (!$user instanceof UserInterface)
        {
            return;
        }
        $data['roles'] =$user->getRoles();
        $event->setData($data);
    }

}