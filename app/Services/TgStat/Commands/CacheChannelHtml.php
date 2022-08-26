<?php

namespace App\Services\TgStat\Commands;

use App\Services\TgStat\Command;
use App\Services\TgStat\Models\TgStatChannel;
use App\Services\TgStat\TgStatService;
use App\Utils\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CacheChannelHtml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tgstat:saveChannelHtml {--slug= : channel slug} {--id= : channel_id} {--name= : filename} {--path=fetch : path to save file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch tsStat channel page and save it to file';

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
        $url  = '';
        $slug = '';

        if ($this->hasOption('id')) {
            $id = $this->option('id');

            if (!$channel = TgStatChannel::find($id)) {
                $this->error("Tg Stat Channel [id=${id}] is undefined");
                return 1;
            }

            $url  = $channel->url;
            $slug = $channel->slug;
        } elseif ($this->hasOption('slug')) {
            $slug = $this->option('slug');
            $url  = TgStatService::getChannelUrl(Str::start($slug, '@'));
        } else {
            $this->error('one of --id or --slug options is required ');
            return 2;
        }

        if (!$html = $this->safelyFetchUrl($url)) {
            $this->error("bad url: '${url}'");
            return 3;
        }

        $path = $this->option('path');
        $name = $this->option('name');

        if (!$name) $name = Str::random() . '.html';

        $path = Helper::concatPath($path, "${slug}.html");

        if (!Storage::disk('local')->put($path, $html)) return $this->error("filed to storage file") || 1;

        $path = Storage::path($path);

        $this->info("saved to '${path}'");

        return 0;
    }
}
