<?php

namespace App\Command;

use App\Entity\Fiction;
use App\Entity\FictionChapter;
use App\Repository\FictionRepository;
use App\Repository\UserRepository;
use App\Repository\UserRoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Goutte\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DomCrawler\Crawler;

class ScrapNoelficCommand extends Command
{
    use ScrapperTrait;

    public const CATEGORIES_SELECTOR = '.center-align p:first-of-type a';
    public const PAGES_LINK_SELECTOR = 'p[style*="float:right;"].retour a:first-of-type';
    public const CATEGORIES_NEXT_PAGE_LINK_SELECTOR = 'ul.pagination li.active + li.waves-effect a';
    public const FIC_CHAPTER_NEXT_PAGE_LINK_SELECTOR = 'ul.collection a[title*="Chapitre {position}"] + a';
    public const FIC_ROW_SELECTOR = 'table.bordered tbody tr';
    public const CHAPTER_BODY_SELECTOR = '.card.grey.lighten-2 .card-content';

    protected static $defaultName = 'app:scrap-noelfic';

    private $client;
    /**
     * @var SymfonyStyle
     */
    private $io;
    private $manager;
    private $fictionRepository;
    private $defaultAuthor;

    public function __construct(EntityManagerInterface $manager,
                                FictionRepository $fictionRepository,
                                UserRepository $userRepository,
                                UserRoleRepository $userRoleRepository,
                                ?string $name = null)
    {
        $this->client = new Client();
        $this->manager = $manager;
        $this->fictionRepository = $fictionRepository;
        $this->defaultAuthor = $userRepository->findOneWithRole(
            $userRoleRepository->findOneBy(['role' => 'ROLE_ADMIN'])
        );
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
        $categories = $page->filter(self::CATEGORIES_SELECTOR);
        $categories->each(function (Crawler $node) {
            $this->scrapByCategory($node);
        });

        $this->io->success('Done');
    }

    protected function scrapByCategory(Crawler $categoryLink): void
    {
        $categoryPage = $this->client->click($categoryLink->link());

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
        $title = $this->getFictionTitle($page);
        if ($found = $this->fictionRepository->findOneBy(compact('title'))) {
            $this->io->text("<comment>Fiction named '$title' (" . $found->getId() . ') already exist. Skipping it...</comment>');
        } else {
            $this->io->section('Scrapping ' . $title);
            $fiction = (new Fiction())
                ->addAuthor($this->defaultAuthor)
                ->setTitle($title);
            $position = 0;
            do {
                $chapter = $this->scrapFicChapter($page, $position);
                $fiction->addChapter($chapter);
                if ($nextPageLink = $this->getNextChapterLink($page, $position)) {
                    $page = $this->client->click(
                        $nextPageLink->link()
                    );
                }
            } while ($this->hasNextChapterPage($page, $position));
            $this->manager->persist($fiction);
            $this->manager->flush();
            $this->io->success("Successfully persisted $title with " . $fiction->getChapters()->count() . ' chapter(s)');
        }
    }

    protected function scrapFicChapter(Crawler $ficPage, int &$position): FictionChapter
    {
        $title = $this->getFictionTitle($ficPage);
        $body = $ficPage->filter(self::CHAPTER_BODY_SELECTOR)->text();
        $chapterTitle = "$title - Chapitre " . ++$position;
        $this->io->text("<info>$chapterTitle</info>");

        return (new FictionChapter())
            ->setTitle($chapterTitle)
            ->setPosition($position)
            ->setBody($body);
    }


}
