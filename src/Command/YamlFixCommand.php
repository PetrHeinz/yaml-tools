<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools\Command;

use PetrHeinz\YamlTools\File;
use PetrHeinz\YamlTools\ItemCollection;
use PhpCsFixer\Differ\UnifiedDiffer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class YamlFixCommand extends Command
{
    public const COMMAND_NAME = 'fix';

    public const EXIT_CODE_ERROR = 1;

    public const EXIT_CODE_SUCCESS = 0;

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->setDescription('Fixes YAML config files.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $contents = file_get_contents(__DIR__ . '/../../example.yml');

        if ($contents === false) {
            $io->error('The file is not readable.');
            return self::EXIT_CODE_ERROR;
        }

        $file = File::fromString($contents);
        $itemCollection = ItemCollection::fromLines($file->toLines());
        $sortedLines = $itemCollection->sort()->toLines();
        $newContents = implode($file->getEol(), array_map('strval', $sortedLines));

        $differ = new UnifiedDiffer();

        echo $differ->diff($contents, $newContents);

        $io->success('Hello world! I am a Fixer from Yaml Tools and one day, I will fix your config files!');

        return self::EXIT_CODE_SUCCESS;
    }
}
