<?php

namespace App\Console\Commands;

use App\Models\ChannelsList;
use App\Processors\TgParser;
use Illuminate\Console\Command;

class ParseCsvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:csv2 {csv_file : path to csv file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse list of channels from CSV file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle(): int
    {
        $file = $this->argument('csv_file');
        $this->info("parse file: $file");

        if (!is_file($file)) {
            $this->error('file not found');
            return 1;
        }

        $ignored  = 0;

        $i = 0;

        $cats = [];

        foreach ($this->getLines($file) as $k => $line) {
            $data = str_getcsv($line);

            if (!($slugObj = TgParser::getChannelSlugInfoOrFalse($data[1]))) {
                $ignored++;
                continue;
            }

            $i++;

            // format:
            // name, link, contact, additional_contact, subjects, subscribers_count, average_post_coverage, adds_cost_for_channels, adds_cost_for_other

            $cat = trim($data[4]);

            if (!key_exists($cat, $cats)) $cats[$cat] = 1;
            else $cats[$cat]++;
        }

        $this->line("Ignored: $ignored");

        dump($cats);

        return 0;
    }

    private static function excludeSpaces(string $value)
    {
        return preg_replace(['#\s+#', '# #'], '', trim($value));
    }

    private function getLines(string $file_name)
    {
        $f = fopen($file_name, 'r');
        try {
            while ($line = fgets($f)) {
                yield $line;
            }
        } finally {
            fclose($f);
        }
    }
}
