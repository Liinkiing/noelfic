<?php

namespace App\Twig;

use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    private $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function getFilters(): array
    {
        return [
            new TwigFilter('props', [$this, 'convertToProps']),
        ];
    }

    public function getFunctions(): array
    {
        return [];
    }

    public function convertToProps($value): string
    {
        return $this->serializer->serialize($value, 'json', ['groups' => ['props']]);
    }
}
