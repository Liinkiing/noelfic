<?php

namespace App\GraphQL\Resolver\Comment;

use App\Entity\Comment;
use App\Entity\FictionChapterComment;
use App\Entity\FictionComment;
use GraphQL\Type\Definition\Type;
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;
use Overblog\GraphQLBundle\Resolver\TypeResolver;

class CommentTypeResolver implements ResolverInterface
{
    private $typeResolver;

    public function __construct(TypeResolver $typeResolver)
    {
        $this->typeResolver = $typeResolver;
    }

    public function __invoke(Comment $question): Type
    {
        if ($question instanceof FictionComment) {
            return $this->typeResolver->resolve('FictionComment');
        }
        if ($question instanceof FictionChapterComment) {
            return $this->typeResolver->resolve('FictionChapterComment');
        }

        throw new UserError('Could not resolve type of Comment.');
    }
}
