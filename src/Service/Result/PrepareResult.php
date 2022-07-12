<?php
namespace App\Service\Result;

use App\Service\Interfaces\PrepareResultInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use App\Service\Interfaces\ResultPaginationInterface;

class PrepareResult implements PrepareResultInterface
{
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var ResultPaginationInterface
     */
    private ResultPaginationInterface $resultPagination;

    public function __construct(RequestStack $requestStack,ResultPaginationInterface $resultPagination)
    {
        $this->requestStack = $requestStack;
        $this->resultPagination = $resultPagination;
    }
    /**
     * prepare result and get it from repository directly or from pagination when add parameters ( page - size )
     * @param ServiceEntityRepositoryInterface $repository
     * @param string $type
     * @param array $options
     * @return array
     */
    public function get(ServiceEntityRepositoryInterface $repository,string $type = 'All',array $options=[]): array
    {
        $request = $this->requestStack->getCurrentRequest();
        if($request->query->get('page') == null)
        {
           return $repository->findAll();
        }
         $resultPagination=$this->resultPagination->get($repository);
         return $resultPagination;
    }
}

