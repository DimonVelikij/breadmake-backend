<?php

namespace Bread\ApiBundle\Controller;

use Bread\ApiBundle\Form\FormInterface;
use Bread\ApiBundle\Service\MailHandler;
use Bread\ApiBundle\Service\UserService;
use Bread\ContentBundle\Entity\Company;
use Bread\ContentBundle\Entity\Order;
use Bread\ContentBundle\Entity\Product;
use Bread\ContentBundle\Entity\ProductOrder;
use Bread\ContentBundle\Entity\Request;
use Bread\ContentBundle\Entity\RequestType;
use Bread\ContentBundle\Repository\CompanyRepository;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\View\View;

/**
 * @Rest\Prefix("request")
 * @Rest\NamePrefix("api-request-")
 *
 * Class RequestController
 * @package Bread\ApiBundle\Controller
 */
class RequestController extends FOSRestController
{
    /**
     * @Rest\Route(path="", methods={"POST"})
     *
     * @Rest\RequestParam(name="Name", nullable=true)
     *
     * @Rest\RequestParam(name="Phone", nullable=true)
     *
     * @Rest\RequestParam(name="Email", nullable=true)
     *
     * @Rest\RequestParam(name="Type", nullable=true)
     *
     * @Rest\RequestParam(name="Agree", requirements="0|1", nullable=true, allowBlank=true, strict=true, default=false)
     *
     * @Rest\RequestParam(name="Token", nullable=true, allowBlank=false, strict=true, default="token")
     *
     * @Rest\RequestParam(name="Data", nullable=true, allowBlank=false, strict=false)
     *
     * @param ParamFetcher $paramFetcher
     *
     * @param ParamFetcher $paramFetcher
     * @return View
     * @throws \Exception
     */
    public function saveAction(ParamFetcher $paramFetcher)
    {
        try {
            /** @var View $view */
            $view = $this->view();

            $formType = $paramFetcher->get('Type');
            $formType = 'bread_api.' . $formType . '_type';

            if (!$this->has($formType)) {
                throw new \Exception("Undefined type '{$formType}'");
            }

            /** @var FormInterface $form */
            $form = $this->get($formType);

            $form->handleRequest($paramFetcher);

            if (!$form->isValid()) {
                return $view->setData([
                    'success'   =>  false,
                    'errors'    =>  $form->getFormErrors()
                ]);
            }

            /** @var UserService $userService */
            $userService = $this->get('bread_api.user_service');
            $user = $userService->findOrCreateUser($paramFetcher);

            /** @var RequestType $requestType */
            $requestType = $this->getRequestType($paramFetcher->get('Type'));

            $request = new Request();
            $request
                ->setType($requestType)
                ->setClient($user)
                ->setData($paramFetcher->get('Data'));

            /** @var EntityManager $em */
            $em = $this->getDoctrine()->getManager();
            $em->persist($request);
            $em->flush();

            $requestProcessFunction = $requestType->getAlias() . 'Process';

            /** @var MailHandler $mailer */
            $mailer = $this->get('bread_api.mail_handler');
            $mailer->send(
                $this->$requestProcessFunction($request),
                $this->getEmailsForSend(),
                $requestType->getTitle(),
                $paramFetcher->get('Type')
            );

            return $view->setData([
                'success'   =>  true,
                'errors'    =>  false
            ]);
        } catch (\Exception $e) {
            return $view->setData([
                'success'   =>  false,
                'errors'    =>  null
            ]);
        }
    }

    /**
     * @param $alias
     * @return object
     */
    private function getRequestType($alias)
    {
        return $this->getDoctrine()
            ->getRepository('BreadContentBundle:RequestType')
            ->findOneBy(['alias' => $alias]);
    }

    /**
     * получение email, на которые нужно отправить письмо
     * @return array
     */
    private function getEmailsForSend()
    {
        /** @var CompanyRepository $companyRepo */
        $companyRepo = $this->getDoctrine()->getRepository('BreadContentBundle:Company');

        /** @var Company $company */
        $company = $companyRepo->findOneCompany();

        return explode(';', $company->getEmail());
    }

    /**
     * обработка заявки обратной связи
     * @param Request $request
     * @return array
     */
    private function feedbackProcess(Request $request)
    {
        return [
            'request'   =>    $request
        ];
    }

    /**
     * обработка заявки заказа
     * @param Request $request
     * @return array
     */
    private function orderProcess(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();

        $orderStatus = $this->getDoctrine()
            ->getRepository('BreadContentBundle:Status')
            ->findOneBy(['alias' => 'wait']);

        $order = new Order();
        $order
            ->setPreferenceDate(new \DateTime($request->getAdditional('PreferenceDate')))
            ->setIsDelivery($request->getAdditional('Delivery'))
            ->setAddress($request->getAdditional('Address'))
            ->setStatus($orderStatus)
            ->setClient($request->getClient());

        $em->persist($order);

        $cart = [];
        foreach ($request->getAdditional('CartContent') as $cartItem) {
            $cart[$cartItem['ProductId']] = $cartItem['Count'];
        }

        $products = $this->getDoctrine()
            ->getRepository('BreadContentBundle:Product')
            ->findBy(['id' => array_keys($cart)]);

        /** @var Product $product */
        foreach ($products as $product) {
            $productOrder = new ProductOrder();
            $productOrder
                ->setProduct($product)
                ->setOrder($order)
                ->setCount($cart[$product->getId()]);

            $order->addProductsOrder($productOrder);

            $em->persist($productOrder);
        }

        $em->flush();

        $this->get('bread_api.cart_service')->clearCart();

        return [
            'request'   =>  $request,
            'order'     =>  $order
        ];
    }
}