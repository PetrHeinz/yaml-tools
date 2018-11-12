<?php

declare(strict_types=1);

namespace PetrHeinz\YamlTools\Command;

use PetrHeinz\YamlTools\File;
use PetrHeinz\YamlTools\ItemCollection;
use PhpCsFixer\Differ\UnifiedDiffer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class YamlFixCommand extends Command
{
    public const COMMAND_NAME = 'fix';

    public const EXIT_CODE_ERROR = 1;

    public const EXIT_CODE_SUCCESS = 0;

    private const OPTION_PATH = 'path';

    protected function configure(): void
    {
        $this
            ->setName(self::COMMAND_NAME)
            ->addArgument(self::OPTION_PATH, InputArgument::REQUIRED)
            ->setDescription('Fixes YAML config files.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $path = $input->getArgument(self::OPTION_PATH);

        if (!is_string($path)) {
            $io->error(sprintf('The path should have been a string, %s provided instead.', gettype($path)));
            return self::EXIT_CODE_ERROR;
        }

        $contents = file_get_contents($path);

        if ($contents === false) {
            $io->error(sprintf('The file "%s" is not readable.', $path));
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
