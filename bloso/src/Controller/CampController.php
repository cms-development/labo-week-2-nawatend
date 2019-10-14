<?php

namespace App\Controller;

use App\Entity\Camp;
use App\Entity\CampTranslation;
use App\Entity\Review;
use DateTime;
use Exception;
use http\Message\Body;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampController extends AbstractController
{
    /**
     * @Route("/{_locale}/camp" , locale="en", requirements={"_locale": "en|nl"}, name="camp")
     */
    public function index()
    {
        return $this->render('camp/index.html.twig', [
            'controller_name' => 'CampController',
        ]);
    }

    /**
     * @Route("/{_locale}/camp/save" , locale="en", requirements={"_locale": "en|nl"}, name="saveCamp")
     */
    public function saveCamp()
    {
        return $this->json(["saved new camp"]);
    }

    /**
     * @Route("/{_locale}/camp/create" , locale="en", requirements={"_locale": "en|nl"}, name="createCamp", methods={"POST", "GET"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function createCamp(Request $request)
    {

        $camp = new Camp();
        $campTranslation = new CampTranslation();


        $form = $this->createFormBuilder($camp)
            ->add("name", TextType::class, ['label' => "Give the name of the camp"])
            ->add("author", TextType::class)
            ->add("date", DateTimeType::class)
            ->getForm();

        $formTranslation = $this->createFormBuilder()
            ->add("quote_en", TextType::class)
            ->add("quote_nl", TextType::class)
            ->add("description_en", TextareaType::class)
            ->add("description_nl", TextareaType::class)
            ->add('save', SubmitType::class)
            ->getForm();


        if ($request->isMethod("post")) {

            $campData = $request->request->get("form");

            //dd($campData);
            $em = $this->getDoctrine()->getManager();

            $camp->setName($campData['name']);
            $camp->setAuthor($campData['author']);
            $camp->setDate(new DateTime($campData['date']['date']['year'] . '-' . $campData['date']['date']['month'] . '-' . $campData['date']['date']['day']));
            $camp->setImage("snelwandelen.png");
            $camp->setLikes(0);
            $camp->setInPreview(0);


            $camp->translate('en')->setQuote($campData['quote_en']);
            $camp->translate('nl')->setQuote($campData['quote_nl']);

            $camp->translate('en')->setDescription($campData['description_en']);
            $camp->translate('nl')->setDescription($campData['description_nl']);


            $camp->mergeNewTranslations();
            $em->persist($camp);
            $em->flush();

            return $this->redirectToRoute("home",['_locale'=>$request->getLocale() ]);
        }

        if ($request->isMethod("get")) {
            return $this->render("camp/new_camp.html.twig", ['form' => $form->createView(), 'formTranslation' => $formTranslation->createView()]);

        }

    }

    /**
     * @Route("/{_locale}/camp/{campId}" , locale="en", requirements={"_locale": "en|nl"}, name="campDetail")
     * @param $campId
     * @return Response
     */
    public function campDetail($campId, Request $request)
    {
        $camps_repo = $this->getDoctrine()->getRepository(Camp::class);

        $camp = $camps_repo->find($campId);


        //form for new review
        $form = $this->createFormBuilder()
            ->setMethod("POST")
            ->add("name", TextType::class, ['label' => "Give reviewer name", 'required' => true])
            ->add("message", TextType::class)
            ->add('post', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        // nakijken of form gesubmit is en gevalideerd is
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            //dd($data);
            $em = $this->getDoctrine()->getManager();
            $camps_repo = $this->getDoctrine()->getRepository(Camp::class);
            $camp = $camps_repo->find($campId);


            $review = new Review();
            $review->setUserName($data["name"]);
            $review->setMessage($data["message"]);
            $review->setCampId($camp);

            $em->persist($review);
            $em->flush();
        }

        return $this->render("camp/detail.html.twig", ['camp' => $camp, 'form' => $form->createView(), 'language' => $request->getLocale()]);
    }

    /**
     * @Route("/{_locale}/like/{campId}", name="likeCamp",methods={"POST"})
     * @param $campId
     * @param Request $request
     * @return JsonResponse
     */
    public function likeCamp($campId, Request $request){
        $camps_repo = $this->getDoctrine()->getRepository(Camp::class);
        $camp = $camps_repo->find($campId);

        $liked = json_decode($request->getContent(),true);

        //dd($liked);
        $newLikes = $camp->getLikes();


        if($liked['liked']){
            $camp->setLikes($camp->getLikes() + 1);

        }else{
            $camp->setLikes($camp->getLikes() - 1);
        }

        if($camp->getLikes() <= 0){
            $camp->setLikes(0);
        }



        $em = $this->getDoctrine()->getManager();
        $em->persist($camp);
        $em->flush();



        return $this->json(['likes' => $camp->getLikes()]);

    }


    /**
     * @Route("/{camp}/delete", name="deleteCamp")
     * @param Camp $camp
     * @return RedirectResponse
     */
    public function deleteCamp(Camp $camp, Request $request){
        $em = $this->getDoctrine()->getManager();
        $em->remove($camp);
        $em->flush();
        return $this->redirectToRoute('home',['_locale' => $request->getLocale()]);
    }



}
