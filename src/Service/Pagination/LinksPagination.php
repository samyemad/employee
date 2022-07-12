<?php
namespace App\Service\Pagination;


use App\Service\Interfaces\LinksPaginationInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class LinksPagination implements LinksPaginationInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private UrlGeneratorInterface $router;

    public function __construct(UrlGeneratorInterface $router)
    {
        $this->router = $router;
    }
    /**
     * get items based on page and size on this page and render links for other pages
     * @param string $routeName
     * @param int $page
     * @param int $size
     * @param int $pages
     * @return array
     */
    public function get(string $routeName,int $page,int $size,int $pages): array
    {
        $links['self']['href']= $this->router->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL)."?page=".$page."&size=".$size;
        $links['first']['href']= $this->router->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL)."?page=1&size=".$size;
        $links['last']['href']= $this->router->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL)."?page=".$pages."&size=".$size;
        if($page != $pages)
        {
            $nextPage=$page+1;
            $links['next']['href']= $this->router->generate($routeName, [], UrlGeneratorInterface::ABSOLUTE_URL)."?page=".$nextPage."&size=".$size;

        }
        return $links;
    }
}

