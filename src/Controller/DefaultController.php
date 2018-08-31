<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $favorites = $this->getUser() instanceof User ? $this->getUser()->getFictionFavorites() : [];

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'favorites' => $favorites
        ]);
    }
}
