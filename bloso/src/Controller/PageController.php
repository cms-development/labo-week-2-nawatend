<?php

namespace App\Controller;

use App\Entity\Camps;
use App\Entity\Reviews;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\DateTime;

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
     * @Route("/camp/save", name="New Camp")
     * @return Response
     */
    public function addNewCamp()
    {
$manager = $this->getDoctrine()->getManager();

$camp =new Camps();

$camp->setTitle("New Camp Title");
$camp->setAuthor("Nawang Tendar");
$camp->setLikes(0);
$camp->setInPreview(false);
$camp->setParagraphs("Habbhaha hahhhahahaha asdsad sad asd");
$camp->setQuote("This is beautiful quote!!!");
$camp->setImage("https://images.pexels.com/photos/1834399/pexels-photo-1834399.jpeg");
$manager->persist($camp);
$manager->flush();

dump($manager);
        return new Response('pauze, new camp added');
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
     * @Route("/camp/save",name="savecamp")
     */
    public function saveCamp(Request $request){

        $manager = $this->getDoctrine()->getManager();

        $camp = new Camps();

        $camp->setTitle("A New Camp");
        $camp->setAuthor("Jezos");
        $camp->setQuote("Well done, my son");
        $camp->setImage("astronaut-profile.png");
        $camp->setParagraphs("This is para something la la la");
        $camp->setInPreview(false);
        $camp->setLikes(0);
//        $camp->setCreatedTime(DateTime::createFromFormat("Y-m-d H:i:s"));
        $manager->persist($camp);
        $manager->flush();

        return $this->render("/");


    }


}
