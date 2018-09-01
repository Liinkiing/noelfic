<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Finder\Finder;

class ExportFixturesCommand extends Command
{
    protected static $defaultName = 'app:export-fixtures';

    protected function configure()
    {
        $this
            ->setDescription('Export fics into fixtures')
            ->addArgument('base_folder', InputArgument::REQUIRED, 'Path of base folder');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $path = $input->getArgument('base_folder');
        $finder = new Finder();
        $finder->in($path)->files();

        foreach ($finder as $file) {
            dump($file->getFilename());
        }

    }

}
