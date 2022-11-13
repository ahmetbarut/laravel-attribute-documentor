<?php

namespace AhmetBarut\Documentor\Commands;

use AhmetBarut\Documentor\FindAttributeDescription;
use AhmetBarut\Documentor\Templates\Markdown;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class GenerateDocumentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'documentor:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $paths = $this->argument('path');
        $directory = $this->option('directory');
        $exportFileName = $this->option('output-file');

        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        $find = new FindAttributeDescription($paths);
        $classes = $find->find();
        $att = $classes->getClassAttributeDescription()->getMethodsDescription()->getPropertiesDescription();

        if (substr($exportFileName, -3) !== '.md') {
            $exportFileName .= '.md';
        }

        $markdown = new Markdown($directory, $exportFileName);

        $markdown->write($att->filter());

        $this->info('Document generated successfully.');

        return Command::SUCCESS;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['path', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'Please specify which directories are scanned'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['directory', 'D', InputOption::VALUE_OPTIONAL, 'Directory to transfer.', base_path('docs')],
            ['output-file', 'O', InputOption::VALUE_OPTIONAL, 'File name to transfer.', 'docs.md'],
        ];
    }
}
