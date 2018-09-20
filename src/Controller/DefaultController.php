<?php

namespace App\Controller;

use App\Entity\Fiction;
use App\Entity\FictionUserFavorite;
use App\Entity\User;
use App\Repository\FictionUserFavoriteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class DefaultController extends BaseController
{
    public function redirectToHome(): RedirectResponse
    {
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        $favorites = $this->getUser() instanceof User ? $this->getUser()->getFictionFavorites() : [];

        return $this->render('default/index.html.twig', [
            'favorites' => $favorites,
        ]);
    }

    /**
     * @Route({"en": "/about", "fr": "/a-propos"}, name="about")
     * @Template("default/about.html.twig")
     */
    public function about(): void
    {
    }
}
