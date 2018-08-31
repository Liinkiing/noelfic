<?php

namespace App\Command;

use App\Entity\Fiction;
use App\Entity\FictionChapter;
use App\Repository\FictionRepository;
use App\Utils\Str;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class ScrapLocalNoelficCommand extends Command
{
    use ScrapperTrait;

    public const INDEX_CATEGORIES_ROW_SELECTOR = 'table tr a';
    public const PAGES_LINK_SELECTOR = 'p[style*="float:right;"].retour a:first-of-type';
    public const CATEGORIES_NEXT_PAGE_LINK_SELECTOR = 'p#pagination span.pagelue + a';
    public const CATEGORIES_FIRST_PAGE_LINK_SELECTOR = 'p#pagination a:first-of-type';
    public const FIC_ROW_SELECTOR = 'table#tablerecherche tbody tr';
    public const CHAPTER_BODY_SELECTOR = '#chapitres';

    protected static $defaultName = 'app:scrap-local-noelfic';

    private $client;
    /**
     * @var SymfonyStyle
     */
    private $io;
    private $manager;
    private $fictionRepository;



    public function __construct(EntityManagerInterface $manager, FictionRepository $fictionRepository, ?string $name = null)
    {
        $this->client = new Client();
        $this->manager = $manager;
        $this->fictionRepository = $fictionRepository;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Scrap noelfic')
            ->addArgument('noelfic_url', InputArgument::REQUIRED, 'The url of noelfic.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->io = new SymfonyStyle($input, $output);
        $url = $input->getArgument('noelfic_url');

        $page = $this->client->request('GET', $url);
        $categories = $page->filter(self::INDEX_CATEGORIES_ROW_SELECTOR);
        $categories->each(function (Crawler $node) {
            if (Str::contains($node->text(), 'Classement par genre')) {
                $this->scrapByCategory($node);
            }
        });

        $this->io->success('Done');
    }

    protected function scrapByCategory(Crawler $categoryLink): void
    {
        $categoryPage = $this->client->click($categoryLink->link());
        if ($firstPageCategoryLink = $this->getFirstPageCategoryLink($categoryPage)) {
            $categoryPage = $this->client->click($firstPageCategoryLink->link());
        }
        do {
            $rows = $categoryPage->filter(self::FIC_ROW_SELECTOR);
            $rows->each(function (Crawler $row) {
                $this->scrapByFic($row);
            });
            if ($nextPageLink = $this->getCategoryNextPageLink($categoryPage)) {
                $categoryPage = $this->client->click(
                    $nextPageLink->link()
                );
            }
        } while ($this->hasCategoryNextPage($categoryPage));
    }

    protected function scrapByFic(Crawler $node): void
    {
        $page = $this->client->click($node->filter('a:first-of-type')->link());
        $title = $this->getPageTitle($page);
        if ($found = $this->fictionRepository->findOneBy(compact('title'))) {
            $this->io->text("<comment>Fiction named '$title' (" . $found->getId() . ') already exist. Skipping it...</comment>');
        } else {
            $this->io->section('Scrapping ' . $title);
            $fiction = (new Fiction())
                ->setTitle($title);
            $position = 0;
            do {
                $chapter = $this->scrapFicChapter($page, $position);
                $fiction->addChapter($chapter);
                if ($nextPageLink = $this->getNextPageLink($page)) {
                    $page = $this->client->click(
                        $nextPageLink->link()
                    );
                }
            } while ($this->hasNextPage($page));
            $this->manager->persist($fiction);
            $this->manager->flush();
            $this->io->success("Successfully persisted $title with " . $fiction->getChapters()->count() . ' chapter(s)');
        }
    }

    protected function scrapFicChapter(Crawler $ficPage, int &$position): FictionChapter
    {
        $title = $this->getPageTitle($ficPage);
        $body = $ficPage->filter(self::CHAPTER_BODY_SELECTOR)->text();
        $this->io->text('<info>' . $title . ' - ' . ++$position . '</info>');

        return (new FictionChapter())
            ->setTitle("$title - Chapitre $position")
            ->setPosition($position)
            ->setBody($body);
    }


}
