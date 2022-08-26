<?php

namespace App\Console\Commands;

use App\Jobs\ParseTelegramChannel;
use App\Models\Channel;
use App\Models\ChannelData;
use App\Models\User;
use App\Processors\TgParser;
use App\Services\HttpClient\HttpClient;
use App\Services\TelegramBot\TelegramBotApi;
use App\Services\TgStatParser;
use DOMXPath;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Psr\Container\ContainerInterface;
use Symfony\Component\Process\Process;
use DOMDocument;
use Illuminate\Support\Facades\App;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

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


    public function handle()
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




    public function handleTDLIB()
    {

        $api_id       = 2495624; // must be an integer
        $api_hash     = 'a5da624ed2dfeb28ef44c6e3651e9012';
        $phone_number = '+79119961430';

        try {
            \TDApi\LogConfiguration::setLogVerbosityLevel(\TDApi\LogConfiguration::LVL_ERROR);

            $client = new \TDLib\JsonClient();

            $tdlibParams = new \TDApi\TDLibParameters();
            $tdlibParams
                ->setParameter(\TDApi\TDLibParameters::USE_TEST_DC, true)
                ->setParameter(\TDApi\TDLibParameters::DATABASE_DIRECTORY, '/var/tmp/tdlib')
                ->setParameter(\TDApi\TDLibParameters::FILES_DIRECTORY, '/var/tmp/tdlib')
                ->setParameter(\TDApi\TDLibParameters::USE_FILE_DATABASE, false)
                ->setParameter(\TDApi\TDLibParameters::USE_CHAT_INFO_DATABASE, false)
                ->setParameter(\TDApi\TDLibParameters::USE_MESSAGE_DATABASE, false)
                ->setParameter(\TDApi\TDLibParameters::USE_SECRET_CHATS, false)
                ->setParameter(\TDApi\TDLibParameters::API_ID, $api_id)
                ->setParameter(\TDApi\TDLibParameters::API_HASH, $api_hash)
                ->setParameter(\TDApi\TDLibParameters::SYSTEM_LANGUAGE_CODE, 'ru')
                ->setParameter(\TDApi\TDLibParameters::DEVICE_MODEL, php_uname('s'))
                ->setParameter(\TDApi\TDLibParameters::SYSTEM_VERSION, php_uname('v'))
                ->setParameter(\TDApi\TDLibParameters::APPLICATION_VERSION, '0.0.10')
                ->setParameter(\TDApi\TDLibParameters::ENABLE_STORAGE_OPTIMIZER, true)
                ->setParameter(\TDApi\TDLibParameters::IGNORE_FILE_NAMES, false);
            $result = $client->setTdlibParameters($tdlibParams);
            $result = $client->setDatabaseEncryptionKey();
            $state  = $client->getAuthorizationState();

            $this->info('state:');
            dump(json_decode($state, true));

            // you must check the state and follow workflow. Lines below is just for an example.
            // $result = $client->setAuthenticationPhoneNumber($phone_number, 3);
            // $this->info('setAuthenticationPhoneNumber');
            // dump($result);

//            $result = $client->query(json_encode([
//                '@type' => 'checkAuthenticationCode',
//                'code' => '73050',
//                'first_name' => 'dummy',
//                'last_name' => 'dummy'
//            ]), 10);

//            $this->info('checkAuthenticationCode');
//            dump($result);

//            $result = $client->query(json_encode(['@type' => 'searchPublicChat', 'username' => 'telegram']), 10);

//            $result = $client->query(json_encode(['@type' => 'acceptTermsOfService']));
//            dump($result);

//            $result = $client->query(json_encode(['@type' => 'registerUser', 'first_name' => 'Maks', 'last_name' => 'Togreh']));
//            dump($result);

            $allNotifications = $client->getReceivedResponses();

            array_walk($allNotifications, function (&$value) {$value = json_decode($value, true);});
            $this->info('getReceivedResponses()');
            dump($allNotifications);
        } catch (\Exception $exception) {
            $this->error('something goes wrong: ' . $exception->getMessage());
        }



    }
}
