<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/users", name="backend_users")
     */
    public function index()
    {
        $users = $this->getDoctrine()
        ->getRepository(User::class)
        ->findAll();

        return $this->render('backend/user/index.html.twig', [
            'users' => $users,
        ]);
    }
}
