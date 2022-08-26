<?php

namespace App\Services\TelegramBot;

use App\Services\TelegramBot\Models\Updates;
use App\Services\TelegramBot\Jobs\ProcessUpdate;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    protected object $api;

    public function __construct(TelegramBotApi $api)
    {
        $this->api = $api;
    }

    public function handle(Request $request, $token): string
    {
        if (!$this->api->checkSecret($token)) abort(404);

        $data = $request->json()->all();

        $update = Updates::create([
            'data' => $data,
        ]);

        ProcessUpdate::dispatch($update);

        return 'ok';
    }
}
