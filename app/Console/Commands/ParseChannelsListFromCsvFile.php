<?php

namespace App\Console\Commands;

use App\Models\ChannelsList;
use App\Processors\TgParser;
use Illuminate\Console\Command;

class ParseChannelsListFromCsvFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:csv {csv_file : path to csv file} {--first= : parse only n first rows}';

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

        $first = $this->option('first');

        if (!is_file($file)) {
            $this->error('file not found');
            return 1;
        }

        $ignored  = 0;
        $added    = 0;
        $public   = 0;
        $private  = 0;
        $checked  = 0;
        $modified = 0;
        $i = 0;

        foreach ($this->getLines($file) as $k => $line) {
            $data = str_getcsv($line);

            if (!($slugObj = TgParser::getChannelSlugInfoOrFalse($data[1]))) {
                $ignored++;
                continue;
            }

            $i++;

            // format:
            // name, link, contact, additional_contact, subjects, subscribers_count, average_post_coverage, adds_cost_for_channels, adds_cost_for_other

            $model = ChannelsList::firstOrNew(['slug' => $slugObj->slug]);

            $model->name      = trim($data[0]);
            $model->tg_link   = trim($data[1]);
            $model->is_public = $slugObj->is_public;
            $model->contact   = trim($data[2]);
            $model->contact2  = trim($data[3]);
            $model->subjects  = trim($data[4]);
            $model->subscribers_count = intval(self::excludeSpaces($data[5]));
            $model->reach_avg = intval(self::excludeSpaces($data[6]));
            $model->post_price = floatval(self::excludeSpaces($data[7]));
            $model->post_price_additional = floatval(self::excludeSpaces($data[8]));

            if ($slugObj->is_public) $public++;
            else $private++;

            if (!$model->exists)  $added++;
            elseif ($model->isDirty()) $modified++;
            else $checked++;

            $model->save();

            if (!is_null($first))
                if ($i >= $first) break;
        }

        $this->line("Ignored: $ignored");
        $this->line("Added: $added");
        $this->line("Checked: $checked");
        $this->line("Modified: $modified");
        $this->line("Public $public, private $private");

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
