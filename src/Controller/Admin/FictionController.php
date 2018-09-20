<?php


namespace App\Controller\Admin;


use App\Controller\BaseController;
use App\Entity\Fiction;
use App\Repository\FictionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\InvalidCsrfTokenException;

/**
 * @Route("/admin/fiction")
 */
class FictionController extends BaseController
{

    /**
     * @Route("/{page<[1-9]\d*>}", name="admin.fiction_index", defaults={"page": "1"}, methods={"GET"})
     */
    public function index(Request $request,
                          FictionRepository $fictionRepository,
                          int $page): Response
    {
        $latest = $fictionRepository->searchLatest($request->query->all(), $page);

        return $this->render('admin/fiction/index.html.twig', [
            'fictions' => $latest,
        ]);
    }

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

    /**
     * @Route("/{id}/delete", name="admin.fiction_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fiction $fiction, EntityManagerInterface $em): Response
    {
        if(!$this->isCsrfTokenValid('delete_' . $fiction->getId(), $request->get('_token'))) {
            throw new InvalidCsrfTokenException('Invalid token');
        }

        $em->remove($fiction);
        $em->flush();

        $this->addFlash('success', [
            'id' => 'flash.fiction.delete',
            'icon' => 'fa fa-check',
            'parameters' => [
                '{fictionTitle}' => $fiction->getTitle()
            ]
        ]);

        return $this->redirectToRoute('admin.fiction_index');
    }

}