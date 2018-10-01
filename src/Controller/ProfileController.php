<?php


namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends BaseController
{

    /**
     * @IsGranted({"ROLE_USER"})
     * @Route("/profile/me", name="profile.me")
     * @Template("profile/me.html.twig")
     */
    public function me(): array
    {
        return [];
    }

}