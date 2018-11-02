<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class YamlFixCommand extends Command
{
    public const COMMAND_NAME = 'fix';

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('Hello world! I am a Fixer from Yaml Tools and one day, I will fix your config files!');
    }

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Fixes YAML config files.');
    }
}
