<?php

namespace App\Controller;

use App\Entity\Fiction;
use App\Repository\FictionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class FictionController extends AbstractController
{
    /**
     * @Route("/fictions", name="fiction.index", defaults={"page": "1"}, methods={"GET"})
     * @Route("/fictions/page/{page<[1-9]\d*>}", name="fiction.index_paginated", defaults={"page": "1"}, methods={"GET"})
     */
    public function index(FictionRepository $fictionRepository, int $page): Response
    {
        $latest = $fictionRepository->findLatest($page);

        return $this->render('fiction/index.html.twig', [
            'fictions' => $latest
        ]);
    }

    /**
     * @Route("/fiction/{slug}/{position<[1-9]\d*>}", name="fiction.show", defaults={"position": "1"}, methods={"GET"})
     */
    public function show(Fiction $fiction, int $position): Response
    {
        $chapter = $fiction->getChapter($position);

        if (!$chapter) {
            throw new NotFoundHttpException('fiction.chapter_not_found');
        }

        return $this->render('fiction/show.html.twig', [
            'fiction' => $fiction,
            'chapter' => $chapter
        ]);
    }
}
