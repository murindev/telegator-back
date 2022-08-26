<?php

namespace App\Services\TgStat\Commands;

use App\Services\TgStat\Command;
use App\Utils\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FetchUrl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tgstat:fetch {url} {--name= : filename} {--path=fetch : path to save file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch html form url and save to file';

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
     */
    public function handle()
    {
        $url  = $this->argument('url');
        $html = $this->safelyFetchUrl($url);

        if (!$html) return $this->error("fetch '${url}' filed") || 1;

        $path = $this->option('path');
        $name = $this->option('name');

        if (!$name) $name = Str::random() . '.html';

        $path = Helper::concatPath($path, $name);

        if (!Storage::disk('local')->put($path, $html)) return $this->error("filed to storage file") || 1;

        $path = Storage::path($path);

        $this->info("saved to '${path}'");

        return 0;
    }
}
