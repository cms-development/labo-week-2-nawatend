<?php

namespace App\Controller;

use App\Entity\Review;
use App\Entity\Camp;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReviewController extends AbstractController
{
//    /**
//     * @Route("/review/save/{campId}"), name="saveReview"
//     * @param $campId
//     * @return RedirectResponse
//     */
//
//    public function saveReview($campId)
//    {
//
//
//        $em = $this->getDoctrine()->getManager();
//
//        $camps_repo = $this->getDoctrine()->getRepository(Camp::class);
//        $camp = $camps_repo->find($campId);
//
//        //dump($_POST);
//        //die();
//
//        $review = new Review();
//        $review->setUserName($_POST['form']["name"]);
//        $review->setMessage($_POST['form']["message"]);
//        $review->setCampId($camp);
//
//        $em->persist($review);
//        $em->flush();
//
//        return $this->redirect("/camp/" . $campId);
//    }
}
