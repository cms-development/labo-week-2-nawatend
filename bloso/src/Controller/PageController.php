<?php

namespace App\Controller;

use App\Entity\Camps;
use App\Entity\Reviews;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
        $camps = $repository->findAll();


        return $this->render("page/index.html.twig",["camps" =>$camps]);
    }

    /**
     * @Route("/camp/save", name="saveCamp")
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







}
