<?php


namespace App\Controller\Admin;


use App\Controller\BaseController;
use App\Entity\Fiction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin/fiction")
 */
class FictionController extends BaseController
{

    /**
     * @Route("/new", name="admin.fiction_new", methods={"GET"})
     * @Template("admin/fiction/new.html.twig")
     */
    public function new(): array
    {
        return [];
    }

    /**
     * @Route("/{id}/edit", name="admin.fiction_edit", methods={"GET"})
     * @Template("admin/fiction/edit.html.twig")
     */
    public function edit(Fiction $fiction): array
    {
        return compact('fiction');
    }

}