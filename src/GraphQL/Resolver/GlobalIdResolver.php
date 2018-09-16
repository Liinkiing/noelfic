<?php

namespace App\GraphQL\Resolver;

use App\Repository\{FictionChapterCommentRepository,
    FictionChapterRepository,
    FictionCommentRepository,
    FictionRepository,
    UserRepository};
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;

class GlobalIdResolver implements ResolverInterface
{

    private $userRepository;
    private $fictionRepository;
    private $fictionCommentRepository;
    private $fictionChapterRepository;
    private $fictionChapterCommentRepository;

    public function __construct(
        UserRepository $userRepository,
        FictionRepository $fictionRepository,
        FictionCommentRepository $fictionCommentRepository,
        FictionChapterRepository $fictionChapterRepository,
        FictionChapterCommentRepository $fictionChapterCommentRepository
    )
    {

        $this->userRepository = $userRepository;
        $this->fictionRepository = $fictionRepository;
        $this->fictionCommentRepository = $fictionCommentRepository;
        $this->fictionChapterRepository = $fictionChapterRepository;
        $this->fictionChapterCommentRepository = $fictionChapterCommentRepository;
    }

    public function __invoke(string $id)
    {
        $node = $this->userRepository->find($id);


        if (!$node) {
            $node = $this->fictionRepository->find($id);
        }

        if (!$node) {
            $node = $this->fictionCommentRepository->find($id);
        }

        if (!$node) {
            $node = $this->fictionChapterRepository->find($id);
        }

        if (!$node) {
            $node = $this->fictionChapterCommentRepository->find($id);
        }

        if (!$node) {
            throw new UserError('Could not find node!');
        }


        return $node;
    }

}