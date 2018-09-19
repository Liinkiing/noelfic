<?php


namespace App\Controller\Admin;


use App\Controller\BaseController;
use App\Repository\CommentRepository;
use App\Repository\FictionRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/admin")
 * @IsGranted({"ROLE_ADMIN"})
 */
class DefaultController extends BaseController
{

    /**
     * @Route("/", name="admin.index")
     * @Template("admin/default/default.html.twig")
     */
    public function index(UserRepository $userRepository,
                          FictionRepository $fictionRepository,
                          CommentRepository $commentRepository): array
    {
        return [
            'stats' => [
                'users' => [
                    'icon' => 'fa fa-user',
                    'name' => 'admin.dashboard.stats.users',
                    'color' => 'green',
                    'count' => $userRepository->count([])
                ],
                'fictions' => [
                    'icon' => 'fa fa-book',
                    'name' => 'admin.dashboard.stats.fictions',
                    'color' => 'red',
                    'count' => $fictionRepository->count([])
                ],
                'comments' => [
                    'icon' => 'fa fa-comment',
                    'name' => 'admin.dashboard.stats.comments',
                    'color' => 'blue',
                    'count' => $commentRepository->count([])
                ]
            ]
        ];
    }

}