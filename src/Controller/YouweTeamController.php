<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\YouweTeam;
use App\Service\Interfaces\ActionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class YouweTeamController extends AbstractController
{
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/youwe_team/{identifier}", name="get_youwe_team", methods={"GET"})
     * @param YouweTeam $youweTeam
     * @return Response
     */
    public function getYouweTeam(YouweTeam $youweTeam,ActionInterface $showYouweTeamAction): Response
    {
        $content=$showYouweTeamAction->process($youweTeam);
        return $this->json($content,Response::HTTP_OK);

    }
    /**
     * @IsGranted("ROLE_USER")
     * @Route("/youwe_teams", name="get_youwe_teams", methods={"GET"})
     * @return Response
     */
    public function getYouweTeams(ActionInterface $showAllYouweTeamsAction): Response
    {
        $content=$showAllYouweTeamsAction->process(null);
        return $this->json($content,Response::HTTP_OK);
    }
}