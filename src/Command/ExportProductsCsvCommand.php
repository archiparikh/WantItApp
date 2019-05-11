<?php

namespace App\Command;

use App\Services\ExportCSV;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ExportProductsCsvCommand extends Command
{
    protected static $defaultName = 'app:export-products-csv';
    private $exportCSVManager;

    public function __construct(ExportCSV $exportCSVManager)
    {
        $this->exportCSVManager = $exportCSVManager;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Export all products in CSV');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        var_dump($this->exportCSVManager->exportAllProducts());
    }
}
