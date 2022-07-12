<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class TokenController
{

    /**
     * @Route("/token", methods={"POST"})
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function getJWT(Request $request)
    {
        //TODO return JWT token for api_user (ROLE_USER) or api_admin (ROLE_ADMIN)
    }
}