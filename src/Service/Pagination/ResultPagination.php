<?php
namespace App\Service\Pagination;

use App\Service\Interfaces\ResultPaginationInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use App\Service\Interfaces\LinksPaginationInterface;

class ResultPagination implements ResultPaginationInterface
{
    CONST SIZE=2;
    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;
    /**
     * @var LinksPaginationInterface
     */
    private LinksPaginationInterface $linksPagination;

    public function __construct(RequestStack $requestStack,LinksPaginationInterface $linksPagination)
    {
        $this->requestStack = $requestStack;
        $this->linksPagination = $linksPagination;
    }
    /**
     * implements pagination and add pagination links to move from page to another
     * @param ServiceEntityRepositoryInterface $repository
     * @param string $type
     * @param array $options
     * @return array
     */
    public function get(ServiceEntityRepositoryInterface $repository,string $type = 'All',array $options=[]): array
    {
        $request = $this->requestStack->getCurrentRequest();
        $routeName=$request->attributes->get('_route');
        $page = (int) $request->query->get('page', 1);
        $size=(int) $request->query->get('size',self::SIZE);
        $allCount=($type == 'All') ? $repository->findAll() : $repository->findBy($options);
        $pagesCount = ceil(count($allCount) / $size);
        $rows = $repository->findBy($options, [], $size, ($size * ($page - 1)));
        $links=[];
        if(!empty($rows))
        {
          $links = $this->linksPagination->get($routeName, $page, $size, $pagesCount);
        }
        return ['page' => $page,'size' => $size,'pages' => $pagesCount,'total' => count($allCount),'_links' => $links,'rows' => $rows];
    }
}

