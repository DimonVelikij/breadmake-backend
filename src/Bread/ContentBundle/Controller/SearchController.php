<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Bread\ContentBundle\Entity\Declaration;
use Bread\ContentBundle\Entity\Menu;
use Bread\ContentBundle\Entity\News;
use Bread\ContentBundle\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends BaseController
{
    /**
     * @Route("/search", name="search")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $search = $request->get('search');

        if (!$search) {
            return $this->redirectToRoute('homepage');
        }

        return $this->render('@BreadContent/Search/search.html.twig', [
            'page'      =>  $this->getPage(),
            'search'    =>  mb_strtolower($search)
        ]);
    }

    /**
     * @Route("/search-data", name="search-data")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $search = $request->get('search');

        if (!$search) {
            return $this->redirectToRoute('homepage');
        }

        $search = mb_strtolower($search);
        $menu = $this->getMenu();

        $products = [
            'part'      =>  $menu['product'] ?? null,
            'result'    =>  []
        ];
        $declarations = [
            'part'      =>  $menu['declaration'] ?? null,
            'result'    =>  []
        ];
        $news = [
            'part'      =>  $menu['news'] ?? null,
            'result'    =>  []
        ];

        //если раздел "Продукты" доступен делаем поиск
        if (array_key_exists('product', $menu)) {
            /** @var Product $product */
            foreach ($this->searchProducts($search) as $product) {
                if (strpos(mb_strtolower($product->getTitle()), $search) !== false) {
                    $products['result'][] = [
                        'text' => $this->searchResultIllumination($product->getTitle(), $search),
                        'link' => $this->generateUrl('product')
                    ];
                    continue;
                }
                if (strpos(mb_strtolower($product->getDescription()), $search) !== false) {
                    $products['result'][] = [
                        'text' => $this->searchResultIllumination($product->getDescription(), $search),
                        'link' => $this->generateUrl('product')
                    ];
                }
            }
        }

        //если раздел "Декларации" доступен делаем поиск
        if (array_key_exists('declaration', $menu)) {
            /** @var Declaration $declaration */
            foreach ($this->searchDeclarations($search) as $declaration) {
                if (strpos(mb_strtolower($declaration->getTitle()), $search) !== false) {
                    $declarations['result'][] = [
                        'text' => $this->searchResultIllumination($declaration->getTitle(), $search),
                        'link' => $this->generateUrl('declaration')
                    ];
                    continue;
                }
                if (strpos(mb_strtolower($declaration->getDescription()), $search) !== false) {
                    $declarations['result'][] = [
                        'text' => $this->searchResultIllumination($declaration->getDescription(), $search),
                        'link' => $this->generateUrl('declaration')
                    ];
                }
            }
        }

        //если раздел "Новости" доступен делаем поиск
        if (array_key_exists('news', $menu)) {
            /** @var News $new */
            foreach ($this->searchNews($search) as $new) {
                if (strpos(mb_strtolower($new->getTitle()), $search) !== false) {
                    $news['result'][] = [
                        'text' => $this->searchResultIllumination($new->getTitle(), $search),
                        'link' => $this->generateUrl('new-item', ['id' => $new->getId()])
                    ];
                    continue;
                }
                if (strpos(mb_strtolower($new->getDescription()), $search) !== false) {
                    $news['result'][] = [
                        'text' => $this->searchResultIllumination($new->getDescription(), $search),
                        'link' => $this->generateUrl('new-item', ['id' => $new->getId()])
                    ];
                }
            }
        }

        return new JsonResponse([
            'products'      =>  $products,
            'declarations'  =>  $declarations,
            'news'          =>  $news
        ]);
    }

    /**
     * @param $string
     * @param $search
     * @return string
     */
    private function searchResultIllumination($string, $search)
    {
        $string = strip_tags($string);

        $start = mb_strpos(mb_strtolower($string), $search);
        $end = $start + mb_strlen($search);

        if ($start === 0) {
            $result =
                '<span class="search-coincidence">' .
                mb_substr($string, 0, $end) .
                '</span>' .
                mb_substr($string, $end, mb_strlen($string) - $end);
        } else {
            $result =
                mb_substr($string, 0, $start) .
                '<span class="search-coincidence">' .
                mb_substr($string, $start, mb_strlen($search)) .
                '</span>' .
                mb_substr($string, $start + mb_strlen($search), mb_strlen($string) - $start - mb_strlen($search));
        }

        return $result;
    }

    /**
     * @return array
     */
    private function getMenu()
    {
        /** @var EntityRepository $menuRepo */
        $menuRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Menu');
        /** @var QueryBuilder $menuQueryBuilder */
        $menuQueryBuilder = $menuRepo->createQueryBuilder('menu');
        $menu = $menuQueryBuilder
            ->where('menu.public = :public')
            ->andWhere($menuQueryBuilder->expr()->in('menu.path', ['product', 'news', 'declaration']))
            ->setParameters(['public' => true])
            ->orderBy('menu.sortableRank')
            ->getQuery()
            ->getResult();

        $menus = [];
        /** @var Menu $menuItem */
        foreach ($menu as $menuItem) {
            $menus[$menuItem->getPath()] = $menuItem->getTitle();
        }

        return $menus;
    }

    /**
     * @param $search
     * @return array
     */
    private function searchProducts($search)
    {
        /** @var EntityRepository $productRepo */
        $productRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Product');

        /** @var QueryBuilder $productQueryBuilder */
        $productQueryBuilder = $productRepo->createQueryBuilder('p');

        $products = $productQueryBuilder
            ->where(
                $productQueryBuilder->expr()->orX(
                    $productQueryBuilder->expr()->like($productQueryBuilder->expr()->lower('p.title'), ':search'),
                    $productQueryBuilder->expr()->like($productQueryBuilder->expr()->lower('p.description'), ':search')
                )
            )
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();

        return count($products) ? $products : [];
    }

    /**
     * @param $search
     * @return array
     */
    private function searchDeclarations($search)
    {
        /** @var EntityRepository $declarationRepo */
        $declarationRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Declaration');

        /** @var QueryBuilder $declarationQueryBuilder */
        $declarationQueryBuilder = $declarationRepo->createQueryBuilder('d');

        $declarations = $declarationQueryBuilder
            ->where(
                $declarationQueryBuilder->expr()->orX(
                    $declarationQueryBuilder->expr()->like($declarationQueryBuilder->expr()->lower('d.title'), ':search'),
                    $declarationQueryBuilder->expr()->like($declarationQueryBuilder->expr()->lower('d.description'), ':search')
                )
            )
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();

        return count($declarations) ? $declarations : [];
    }

    /**
     * @param $search
     * @return array
     */
    private function searchNews($search)
    {
        /** @var EntityRepository $newRepo */
        $newRepo = $this->getDoctrine()->getRepository('BreadContentBundle:News');

        /** @var QueryBuilder $newQueryBuilder */
        $newQueryBuilder = $newRepo->createQueryBuilder('n');

        $news = $newQueryBuilder
            ->where(
                $newQueryBuilder->expr()->orX(
                    $newQueryBuilder->expr()->like($newQueryBuilder->expr()->lower('n.title'), ':search'),
                    $newQueryBuilder->expr()->like($newQueryBuilder->expr()->lower('n.description'), ':search')
                )
            )
            ->setParameter('search', '%' . $search . '%')
            ->getQuery()
            ->getResult();

        return count($news) ? $news : [];
    }
}