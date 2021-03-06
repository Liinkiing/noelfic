<?php


namespace App\Command;


use Symfony\Component\DomCrawler\Crawler;

trait ScrapperTrait
{

    protected function getFirstPageCategoryLink(Crawler $page): ?Crawler
    {
        return $page->filter(self::CATEGORIES_FIRST_PAGE_LINK_SELECTOR)->count() > 0 ?
            $page->filter(self::CATEGORIES_FIRST_PAGE_LINK_SELECTOR)->first() :
            null;
    }

    protected function getNextPageLink(Crawler $page): ?Crawler
    {
        $result = null;
        $page->filter(self::PAGES_LINK_SELECTOR)->each(function (Crawler $link) use (&$result) {
            $result = $link;
        });

        return $result;
    }

    protected function getNextChapterLink(Crawler $page, int $position): ?Crawler
    {
        $selector = str_replace('{position}', $position, self::FIC_CHAPTER_NEXT_PAGE_LINK_SELECTOR);
        return $page->filter($selector)->count() > 0 ?
            $page->filter($selector)->first() :
            null;
    }

    protected function getCategoryNextPageLink(Crawler $page): ?Crawler
    {
        return $page->filter(self::CATEGORIES_NEXT_PAGE_LINK_SELECTOR)->count() > 0 ?
            $page->filter(self::CATEGORIES_NEXT_PAGE_LINK_SELECTOR)->first() :
            null;
    }

    protected function hasCategoryNextPage(Crawler $categoryPage): bool
    {
        return $this->getCategoryNextPageLink($categoryPage) !== null;
    }

    protected function hasNextPage(Crawler $page): bool
    {
        return $this->getNextPageLink($page) !== null;
    }

    protected function hasNextChapterPage(Crawler $page, int $position): bool
    {
        return $this->getNextChapterLink($page, $position) !== null;
    }

    protected function getPageTitle(Crawler $page): string
    {
        return $page->filter('title')->text();
    }

    protected function getFictionTitle(Crawler $ficPage): string
    {
        return $ficPage->filter('.center-align h4:first-of-type')->text();
    }
}