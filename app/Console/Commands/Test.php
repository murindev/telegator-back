<?php

namespace App\Console\Commands;

use App\Jobs\ParseTelegramChannel;
use App\Jobs\ParseTelegramChannelOfficialInfo;
use App\Models\Campaign;
use App\Models\CampaignContent;
use App\Models\Category;
use App\Models\Channel;
use App\Models\ChannelData;
use App\Models\ChannelsList;
use App\Models\Claim;
use App\Services\MemoryService;
use App\Services\TgStat\Jobs\ParseTgStatChannelInfo;
use App\Services\TgStat\Models\TgStatChannel;
use App\Models\User;
use App\Processors\TgParser;
use App\Services\HttpClient\HttpClient;
use App\Services\TelegramBot\TelegramBotApi;
use App\Services\TgStat\Models\TgStatPost;
use App\Services\TgStat\TgStatParser;
use App\Services\TgStat\TgStatService;
use App\Services\Tme\TmeParser;
use App\Services\Tme\TmeService;
use App\Utils\Checker;
use App\Utils\DOMDocumentXPathParser;
use App\Utils\Helper;
use DOMXPath;
use App\Services\TgStat\Command;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\File;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Psr\Container\ContainerInterface;
use Symfony\Component\Process\Process;
use DOMDocument;
use Illuminate\Support\Facades\App;
use Telegram\Bot\Laravel\Facades\Telegram;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 't';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for test something';

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

    public function handleBot()
    {
        $bot = new TelegramBotApi(['token' => '411036603:AAFNSMDFYvIiQ0bLWLKEXqmlRvhQGwr0kWE']);
        //        $data = $bot->getMe();
        //        $data = $bot->simpleCall('getChatAdministrators', ['chat_id' => '@obvchannel']);
        //        dump($data);
        //        $data = $bot->simpleCall('getChatMember', ['chat_id' => '@obvchannel', 'user_id' => 411036603]);
        //        dump($data);
        $res = $bot->sendTextMessage(-1001328950981, 'MarkdownV2 test
*bold \*text*
_italic \*text_
__underline__
~strikethrough~
*bold _italic bold ~italic bold strikethrough~ __underline italic bold___ bold*
[inline URL](http://www.example.com/)
[inline mention of a user](tg://user?id=411036603)
`inline fixed-width code`
```
pre-formatted fixed-width code block
```
```python
pre-formatted fixed-width code block written in the Python programming language
```', 0, 'MarkdownV2');
        dump($res);
        $data = $bot->getUpdates();
        dump($data);
    }

    public function handleParser()
    {
        $slug   = 'breakingmash';
        $parser = App::make(TgStatParser::class);
        $data   = $parser->fetchChannelAndPosts(TgStatParser::getTgStatChannelSlug($slug, true));

        dump($data);
    }

    public function handleLoadHTML()
    {
        $slug = 'breakingmash';
        $url  = TgStatParser::TGSTAT_CHANNEL_URL_PREFIX . TgStatParser::getTgStatChannelSlug($slug, true);
        $this->info('parse url: ' . $url);
        $ch  = App::make(HttpClient::class);
        $res = $ch->fetch($url);

        $a = file_put_contents("/hdd/default/{$slug}.html", $res);

        dump($a);
    }

    public function handleChannelExists()
    {
        $variants = ['trash'           => 'https://t.me/obvchandflghjksgjsdfhgkjsdhfjghkdjhgjdshfsgisdhfighsdiuhgiudsfhgiuhdfg',
                     'user'            => 'https://t.me/obvchan', 'channel' => 'https://t.me/obvchannel',
                     'channel2'        => 'https://t.me/breakingmash',
                     'private_channel' => 'https://t.me/joinchat/AAAAAEvTP-vtBJyjj-0cew',
                     'user2'           => 'https://t.me/der_herrgott',];

        foreach ($variants as $k => $v) {
            $a = TmeService::channelExists($v);
            $b = $a ? '+' : '-';
            $this->info("check '$k': $b");
        }

        return 1;
    }

    public function handle3()
    {
        $h = \Storage::disk('local')->get('fetch/@breakingmash.html');
        $p = TgStatParser::initParser($h);
        $d = TgStatParser::parseChannelInfo($p);

        dump($d);

        return 0;

        $p             = new TgStatPost();
        $p->channel_id = 2;
        $p->post_id    = 20000;

        dump($p->url);

        $parser = $this->service->fetchUrlAndInitParser($p->url);
        $data   = TgStatParser::parsePost($parser);

        dump($data);

        return 1;
    }

    public function handleLoadTgStatPost()
    {
        $t = ['breakingmash-20000-stat' => 'https://tgstat.ru/en/channel/@breakingmash/20000/stat',
              'breakingmash-20000-post' => 'https://tgstat.ru/en/channel/@breakingmash/20000',];

        $ch = App::make(HttpClient::class);

        foreach ($t as $slug => $url) {
            $res = $ch->fetch($url);
            file_put_contents("/hdd/default/{$slug}.html", $res);
        }

        return 1;
    }

    public function handleBotTests()
    {
        $bot = new TelegramBotApi([
            'token' => env('Orange_BOT_TOKEN'),
            'name'  => 'Orange bot',
            'secret' => 'qwe'
        ]);

//        $res = $bot->getUpdates(false);

        $res['getChat'] = $bot->simpleCall('getChat', ['chat_id' => -1001413676257]);
        $res['getChatAdministrators'] = $bot->simpleCall('getChatAdministrators', ['chat_id' => -1001413676257]);
        $res['getChatMembersCount']   = $bot->simpleCall('getChatMembersCount', ['chat_id' => -1001413676257]);

        dump($res);

        return 1;
    }

    public function handle()
    {
//        $claim = Claim::where([
//            'user_id' => 13,
//            'link' => 'https://t.me/joinchat/yVcEmmTZa7YzYmVi'
//        ])->get();

//        $response = Telegram::sendMessage([
//            'chat_id' => 112633945,
//            'text'    => 'Yo man'
//        ]);

        $response = Telegram::getUpdates();

        $res = [];

        foreach ($response as $item) {
            $res []= $item->detectType();
        }

        dump($res);

//        $u = $response[3];
//        dump($u);
//        dump($u->getMessage());
//        dump($u->detectType());

        return 1;
    }
}
