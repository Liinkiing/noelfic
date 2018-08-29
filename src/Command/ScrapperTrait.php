<?php


namespace App\Command;


use Symfony\Component\DomCrawler\Crawler;

trait ScrapperTrait
{
    protected function getNextPageLink(Crawler $page): ?Crawler
    {
        $result = null;
        $page->filter(self::PAGES_LINK_SELECTOR)->each(function (Crawler $link) use (&$result) {
            $result = $link;
        });

        return $result;
    }

    protected function hasNextPage(Crawler $page): bool
    {
        return $this->getNextPageLink($page) !== null;
    }

    protected function getPageTitle(Crawler $page): string
    {
        return $page->filter('title')->text();

    }
}