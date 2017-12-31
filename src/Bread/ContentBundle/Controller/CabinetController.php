<?php

namespace Bread\ContentBundle\Controller;

use Bread\ContentBundle\Controller\Base\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class CabinetController extends BaseController
{
    /**
     * авторизация
     * @Route("/cabinet/login", name="cabinet-login")
     * @param Request $request
     */
    public function loginAction(Request $request)
    {
        dump('cabinet-login');die;
    }

    /**
     * регистрация
     * @Route("/cabinet/registration", name="cabinet-registration")
     * @param Request $request
     */
    public function registrationAction(Request $request)
    {
        dump('cabinet-registration');die;
    }

    /**
     * выход
     * @Route("/cabinet/logout", name="cabinet-logout")
     * @param Request $request
     */
    public function logoutAction(Request $request)
    {
        dump('cabinet-logout');die;
    }

    /**
     * @Route("/cabinet", name="cabinet")
     * @param Request $request
     */
    public function cabinetAction(Request $request)
    {
        dump('cabinet');die;
    }
}