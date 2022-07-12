<?php
namespace App\Service\Action;

use App\Service\Interfaces\ActionInterface;
use App\Service\Interfaces\EntityHandlerInterface;
use App\Service\Interfaces\PrepareResultInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use App\Repository\YouweTeamRepository;

class ShowAllYouweTeamsAction implements ActionInterface
{
    /**
     * @var EntityHandlerInterface
     */
    private EntityHandlerInterface $entitySerializerHandler;
    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $youweTeamNormalizer;
    /**
     * @var NormalizerInterface
     */
    private NormalizerInterface $employeeNormalizer;
    /**
     * @var PrepareResultInterface
     */
    private PrepareResultInterface $prepareResult;
    /**
     * @var YouweTeamRepository
     */
    private YouweTeamRepository $youweTeamRepository;

    public function __construct(
        EntityHandlerInterface $entitySerializerHandler,
        NormalizerInterface $youweTeamNormalizer,
        NormalizerInterface $employeeNormalizer,
        PrepareResultInterface $prepareResult,
        YouweTeamRepository $youweTeamRepository
    )
    {
        $this->entitySerializerHandler =  $entitySerializerHandler;
        $this->youweTeamNormalizer =  $youweTeamNormalizer;
        $this->employeeNormalizer =  $employeeNormalizer;
        $this->prepareResult = $prepareResult;
        $this->youweTeamRepository = $youweTeamRepository;
    }
    /**
     * Show All Youwe Teams and transform it from normalizer Serializer
     * @param mixed $inputParam
     * @return array
     */
    public function process($inputParam): array
    {
        $allYouweTeams=$this->prepareResult->get($this->youweTeamRepository);
        $normalizersArray=[$this->youweTeamNormalizer,$this->employeeNormalizer];
        $content= $this->entitySerializerHandler->process($allYouweTeams,'list',$normalizersArray);
        return $content;
    }
}

