<?php

namespace Bread\ApiBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * удалить этот класс
 * @Rest\Prefix("standart")
 * @Rest\NamePrefix("api-standart-")
 *
 * Class SliderController
 * @package Bread\ApiBundle\Controller
 */
class StandartController extends FOSRestController
{
    /**
     * тестовые данные
     * @var array
     */
    static $data = [
        1 => [
            'title' => 'Name1'
        ],
        2 => [
            'title' => 'Name2'
        ]
    ];

    /**
     * @Rest\Route(path="", methods={"GET"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @return array
     */
    public function resourceAction()
    {
        //получение всех данных сущности
        return [self::$data];
    }

    /**
     * @Rest\Route(path="/{id}", methods={"GET"}, requirements={"id": "\d+"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     *
     * @return array|null
     */
    public function resourceItemAction(int $id)
    {
        if (!isset(self::$data[$id])) {
            throw new NotFoundHttpException('Undefined object with id ' . $id);
        }

        return self::$data[$id];
    }

    /**
     * @Rest\Route(path="", methods={"POST"})
     *
     * @Rest\RequestParam(
     *     name="title",
     *     requirements="([a-zA-Z0-9]+)",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true
     * )
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param ParamFetcher $paramFetcher
     * @return array
     */
    public function addItemAction(ParamFetcher $paramFetcher)
    {
        //добавление сущности
        $title = $paramFetcher->get('title');

        self::$data[3] = [
            'title' => $title
        ];

        return [3 => self::$data[3]];
    }

    /**
     * @Rest\Route(path="/{id}", methods={"PUT"}, requirements={"id": "\d+"})
     *
     * @Rest\RequestParam(
     *     name="title",
     *     requirements="([a-zA-Z0-9]+)",
     *     nullable=false,
     *     allowBlank=false,
     *     strict=true
     * )
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     * @param ParamFetcher $paramFetcher
     * @return mixed|null
     */
    public function updateItemAction(int $id, ParamFetcher $paramFetcher)
    {
        //обновление сущности
        if (!isset(self::$data[$id])) {
            throw new NotFoundHttpException('Undefined object with id ' . $id);
        }

        $item = self::$data[$id];

        $item['title'] = $paramFetcher->get('title');

        return [$id => self::$data[$id]];
    }

    /**
     * @Rest\Route(path="/{id}", methods={"DELETE"}, requirements={"id": "\d+"})
     *
     * @Rest\View(
     *     serializerGroups={"api"},
     *     statusCode=200
     * )
     *
     * @param int $id
     * @return true|null
     */
    public function deleteAction(int $id)
    {
        if (!isset(self::$data[$id])) {
            throw new NotFoundHttpException('Undefined object with id ' . $id);
        }

        unset(self::$data[$id]);

        return true;
    }
}