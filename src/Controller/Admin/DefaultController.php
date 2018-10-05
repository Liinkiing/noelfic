<?php


namespace App\Controller\Admin;


use App\Controller\BaseController;
use App\Repository\CommentRepository;
use App\Repository\FictionRepository;
use App\Repository\UserRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

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
    public function index(Request $request,
                          UserRepository $userRepository,
                          FictionRepository $fictionRepository,
                          CommentRepository $commentRepository,
                          TranslatorInterface $translator): array
    {
        $userChartData = $userRepository->countRegistrationPerDaysOfWeek($request->getLocale());
        $fictionChartData = $fictionRepository->countFictionPerDaysOfWeek($request->getLocale());
        $commentChartData = $commentRepository->countCommentPerDaysOfWeek($request->getLocale());

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
            ],
            'charts' => [
                'users' => [
                    'title' => $translator->trans("admin.dashboard.charts.new_users"),
                    'color' => 'green',
                    'data' => $userChartData,
                    'options' => [
                        'axisY' => ['onlyInteger' => true],
                        'high' =>  max($userChartData['series'][0]) + 1,
                        'chartPadding' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0
                        ]
                    ]
                ],
                'fictions' => [
                    'title' => $translator->trans("admin.dashboard.charts.new_fictions"),
                    'color' => 'red',
                    'data' => $fictionChartData,
                    'options' => [
                        'axisY' => ['onlyInteger' => true],
                        'high' => max($fictionChartData['series'][0]) + 1,
                        'chartPadding' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0
                        ]
                    ],
                ],
                'comments' => [
                    'title' => $translator->trans("admin.dashboard.charts.new_comments"),
                    'color' => 'blue',
                    'data' => $commentChartData,
                    'options' => [
                        'axisY' => ['onlyInteger' => true],
                        'high' => max($commentChartData['series'][0]) + 1,
                        'chartPadding' => [
                            'top' => 0,
                            'right' => 0,
                            'bottom' => 0,
                            'left' => 0
                        ]
                    ],
                ]
            ],
            'bestFictions' => [
                'color' => 'orange',
                'name' => 'admin.dashboard.bestFictions.name',
                'subtitle' => 'admin.dashboard.bestFictions.subtitle',
                'items' => $fictionRepository->getLastBestFictions()
            ]
        ];
    }

}