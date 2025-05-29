<?php

namespace AloneWebMan\Code\Command;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProcessExec extends Command {
    protected static $defaultName = 'alone:process';

    protected static $defaultDescription = 'process create <info>[*name] [type]</info>';

    protected function configure(): void {
        $this->addArgument('key', InputArgument::OPTIONAL, 'key');
    }

    public function execute(InputInterface $input, OutputInterface $output): int {
        $key = $input->getArgument('key');
        echo "--------------------------------------------------------\r\n";
        print_r($key);
        /*
         * (new Table($output))->setHeaders([])->setRows([])->render();
         */
        echo "--------------------------------------------------------\r\n";
        return self::SUCCESS;
    }
}