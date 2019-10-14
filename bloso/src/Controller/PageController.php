<?php

namespace App\Controller;

use App\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    /**
     * @Route("/{_locale}", locale="en", requirements={"_locale": "en|nl"}, name="home")
     *
     */
    public function index(Request $request)
    {




        //dd($locale);
        $repository = $this->getDoctrine()->getRepository(Camp::class);

        // look for multiple Product objects matching the name, ordered by price

        $camps = $repository->findBy(array(), array('id' => 'desc'), 4);
        $inPreview = $repository->findBy(["in_preview" => 1]);

        return $this->render("page/index.html.twig", ["camps" => $camps, 'inPreview' => $inPreview, 'language'=> $request->getLocale() ]);

    }

    /**
     * @Route("/contacts", name="contacts")
     */
    public function getContacts(){
        return $this->render("page/contacts.html.twig");

    }

//    /**
//     * @Route ("/{locale}", name="changeLocale")
//     * @param $locale
//     * @param RequestEvent $event
//     */
//    public function changeLocale($locale, RequestEvent $event){
//
//        $request = $event->getRequest();
//
//        // some logic to determine the $locale
//        $request->setLocale($locale);
//    }





}
