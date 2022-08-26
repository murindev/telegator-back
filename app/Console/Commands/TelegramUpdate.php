<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Telegram\Bot\BotsManager as Telegram;
use Telegram\Bot\Exceptions\TelegramSDKException;

class TelegramUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:updates {bot?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Telegram updates';

    protected Telegram $telegramSdk;

    /**
     * Create a new command instance.
     *
     * @param Telegram $telegramSdk
     */
    public function __construct(Telegram $telegramSdk)
    {
        parent::__construct();
        $this->telegramSdk = $telegramSdk;
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws TelegramSDKException
     */
    public function handle()
    {
        try {
            $bot = $this->telegramSdk->bot($this->argument('bot'));
        } catch (\InvalidArgumentException $e) {
            $this->error('Undefined bot');

            return 1;
        }

        $this->info($bot->getMe());

        $res = $bot->getUpdates();

        foreach ($res as $update) {
            dump($update->getRawResponse());
            dump($update->detectType());
        }

//        dd($res);

        return 0;
    }
}
