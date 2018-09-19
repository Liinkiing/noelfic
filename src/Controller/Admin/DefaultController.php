<?php


namespace App\Controller\Admin;


use App\Controller\BaseController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 */
class DefaultController extends BaseController
{

    /**
     * @Route("/", name="admin.index")
     * @Template("admin/default/default.html.twig")
     */
    public function index(): void
    {

    }

}