<?php

namespace App\Controller;

use App\Entity\Camps;
use App\Entity\Reviews;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class PageController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     *
     * @return Response
     */
    public function index()
    {

        $repository = $this->getDoctrine()->getRepository(Camps::class);

        // look for multiple Product objects matching the name, ordered by price

    $camps = $repository->findBy(array(), array('created_time' => 'desc'), 4);
    $inPreview = $repository->findBy(["in_preview"=> 1]);

        return $this->render("page/index.html.twig",["camps" =>$camps, 'inPreview' => $inPreview]);
    }

    /**
     * @Route("/camp/save", name="saveCamp", methods={"POST"})
     *
     */
    public function addNewCamp(){


        $manager = $this->getDoctrine()->getManager();

        $camp = new Camps();

        $camp->setTitle($_POST['campTitle']);
        $camp->setAuthor($_POST['campAuthor']);
        $camp->setQuote($_POST['campQuote']);
        $camp->setImage("snelwandelen.png");
        $camp->setParagraphs($_POST['campDescription']);
        $camp->setInPreview(false);
        $camp->setLikes(0);
        //createdTime in constructor
        //$camp->setCreatedTime(DateTime::createFromFormat("Y-m-d H:i:s"));
        $manager->persist($camp);
        $manager->flush();

        return $this->redirectToRoute('homepage');


    }

    /**
     * @param $campTitle
     * @Route("/camp/{campTitle}", name="campdetail")
     * @return Response
     */
    public function campDetail($campTitle){


        $camps_repo = $this->getDoctrine()->getRepository(Camps::class);
        $reviews_repo = $this->getDoctrine()->getRepository(Reviews::class);
        $camp = $camps_repo->findOneBy(['title'=> $campTitle]);

        $reviews = $reviews_repo->findBy(['camp_id'=>$camp->getId()]);
        return $this->render('page/camp_detail.html.twig',['camp'=>$camp, 'reviews'=>$reviews]);
    }

    /**
     * @Route("/camp/new/create",name="newcamp")
     */
    public function createCamp(){
        return $this->render('page/create_camp.html.twig');
    }

    /**
     * @Route("/camp/review/new/{camp_id}", name="saveReview", methods={"POST"})
     * @param $camp_id
     * @param Request $request
     * @return RedirectResponse
     */
    public function addReview($camp_id, Request $request){
        $manager = $this->getDoctrine()->getManager();

        $review = new Reviews();
        $review->getCampId($camp_id);
        $review->setReviewerName($_POST["reviewerName"]);
        $review->setMessage($_POST["reviewMessage"]);

        $manager->persist($review);
        $manager->flush();

        return $this->redirect($request->getUri());

    }






}
