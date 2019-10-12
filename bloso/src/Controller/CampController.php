<?php

namespace App\Controller;

use App\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Routing\Annotation\Route;

class CampController extends AbstractController
{
    /**
     * @Route("/camp", name="camp")
     */
    public function index()
    {
        return $this->render('camp/index.html.twig', [
            'controller_name' => 'CampController',
        ]);
    }

    /**
     * @Route("/camp/save", name="saveCamp")
     */
    public function saveCamp()
    {
        return $this->json(["saved new camp"]);
    }

    /**
     * @Route("/camp/create", name="createCamp")
     */
    public function createCamp()
    {

        $camp = new Camp();
        $form = $this->createFormBuilder()
            ->add("name", TextType::class, ['label' => "Give the name of the camp"])
            ->add("author", TextType::class)
            ->add("date", DateTimeType::class)
            ->add("quote", TextType::class)
            ->add("description", TextareaType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $camp->setLikes(0);
        $camp->setInPreview(0);
        $camp->setImage("snelwandelen.png");
        $camp->setAuthor("Jezos");

        $camp->setName("Just Run");
        $camp->setDate(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($camp);
        $em->flush();


        return $this->render("camp/new_camp.html.twig", ['form' => $form->createView()]);

    }

    public function campDetail($camp_id)
    {

        $camp = new Camp();
        $this->render("camp/detail.html.twig", ['camp' => $camp]);
    }
}
