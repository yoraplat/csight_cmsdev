<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Period;
use App\Form\EditPeriodFormType;
use App\Form\NewPeriodFormType;

class DashboardController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="backend_dashboard")
     */
    public function index()
    {
        // Get all periods
        $periods = $this->getDoctrine()
        ->getRepository(Period::class)
        ->findAll();

        // dd($periods);

        return $this->render('backend/dashboard/index.html.twig', [
            "periods" => $periods,
        ]);
    }
    
    /**
     * @Route("/admin/period/create", name="add_period")
     */
    public function addPeriod(Request $request)
    {
        $period = new Period();
        // $task->setTask('Write a blog post');

        $form = $this->createForm(NewPeriodFormType::class, $period);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $period = $form->getData();
            $period->setClientId($period->getClient()->getId());
            $period->setAcceptedByClient(false);
            $period->setCreatedAt(new \DateTime);
            // dd($period);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($period);
            $entityManager->flush();

            return $this->redirectToRoute('backend_dashboard');
        }
        

        return $this->render('backend/period/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/period/{id}/edit", name="edit_period")
     */
    public function editPeriod(Period $period, $id, Request $request)
    {

        $form = $this->createForm(EditPeriodFormType::class, $period, array(
            'method' => 'PUT',
        ));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $period = $form->getData();
            $period->setClientId($period->getClient()->getId());
            $period->setUpdatedAt(new \DateTime);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($period);
            $entityManager->flush();

            return $this->redirectToRoute('backend_dashboard');
        }
        

        return $this->render('backend/period/update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
