<?php

namespace App\GraphQL\Resolver\Type;

use App\Entity\{Fiction, FictionChapter, FictionChapterComment, FictionComment, User};
use Overblog\GraphQLBundle\Definition\Resolver\ResolverInterface;
use Overblog\GraphQLBundle\Error\UserError;
use Overblog\GraphQLBundle\Resolver\TypeResolver;

class NodeTypeResolver implements ResolverInterface
{

    private $resolver;

    public function __construct(TypeResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    public function __invoke($node)
    {
        if ($node instanceof User) {
            return $this->resolver->resolve('User');
        }

        if ($node instanceof Fiction) {
            return $this->resolver->resolve('Fiction');
        }

        if ($node instanceof FictionComment) {
            return $this->resolver->resolve('FictionComment');
        }

        if ($node instanceof FictionChapter) {
            return $this->resolver->resolve('FictionChapter');
        }

        if ($node instanceof FictionChapterComment) {
            return $this->resolver->resolve('FictionChapterComment');
        }

        throw new UserError("Can't resolve node type!");
    }

}