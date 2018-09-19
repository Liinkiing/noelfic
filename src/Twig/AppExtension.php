<?php

namespace App\Twig;

use Detection\MobileDetect;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

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
            new TwigFilter('regex_replace', [$this, 'regexReplace'])
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('is_touch_device', [$this, 'isTouchDevice'])
        ];
    }

    public function isTouchDevice(): bool
    {
        $mb = new MobileDetect();

        return $mb->isMobile() || $mb->isTablet();
    }

    public function regexReplace($value, $pattern, $replacement): string
    {
        return preg_replace($pattern, $replacement, $value);
    }

    public function convertToProps($value): string
    {
        return $this->serializer->serialize($value, 'json', ['groups' => ['props']]);
    }
}
