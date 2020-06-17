<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="frontend_dashboard")
     */
    public function index()
    {
        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('backend_dashboard');
        } else {
            return $this->render('frontend/dashboard.html.twig', [
                'controller_name' => 'DashboardController',
            ]);
        }
    }
}
