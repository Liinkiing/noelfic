<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(SerializerInterface $serializer): Response
    {
        $favorites = $this->getUser() instanceof User ? $this->getUser()->getFictionFavorites() : [];

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'favorites' => $favorites,
            'favoritesProps' => $serializer->serialize($favorites, 'json', ['groups' => ['props']])
        ]);
    }

    /**
     * @Route({"en": "/about", "fr": "/a-propos"}, name="about")
     * @Template("default/about.html.twig")
     */
    public function about(): void {}
}
