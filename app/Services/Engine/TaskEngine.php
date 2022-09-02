<?php

namespace App\Services\Engine;

use App\Models\Channel;
use App\Models\Task\TaskChannel;
use App\Models\Tgstat\TgstatPost;
use App\Models\User;
use Carbon\Carbon;

class TaskEngine
{
    private $daily = [1, 4];

    private $twoDaily = [2, 5];

    private $forever = [3];

    private TaskChannel $refreshedTaskChannel;

    private $day = 86400;
    private $hour = 3600;

    public function __construct()
    {
        $this->handle();

    }

    public function handle()
    {
        $taskChannels = TaskChannel::with(['task', 'tgstat_post.tgstat_post_stat'])->whereIn('state', [1, 2, 3, 4])->get();
        foreach ($taskChannels as $taskChannel)   {
/*            if($taskChannel->id === 72) {
                $channel = str_replace('https://','',$taskChannel->channel->tg_link);
                $rr = shell_exec("bash -c 'python3 ".config('app.parser_path')."batch_channel.py ".$channel." batch_channel'");
                dump($rr);
                dump($taskChannel->toArray());
            }*/
            $this->checkTaskChannel($taskChannel);
        }
    }


    public function checkTaskChannel($taskChannel)
    {

        switch ($taskChannel->state) {
            case 1;
                $this->newTask($taskChannel);
                break;
            case 2;
                $this->accepted($taskChannel);
                break;
            case 3;
                $this->published($taskChannel);
                break;
            case 4;
                $this->processing($taskChannel);
                break;
        }

    }


    /**
     * State 1
     * Админ должен принять задание
     * Проверка на ожидание в течение суток.
     * Если больше суток не опубликовано вернуть деньги.
     * Перевести в state 8
     * @return void
     */
    public function newTask(TaskChannel $taskChannel)
    {
        if ($this->days($taskChannel) > 0) {
            $this->moneyBack($taskChannel);
            $this->setState($taskChannel, 8);
        }
    }

    /**
     * State 2
     * Админ принял задание и ждет подтверждения реламода...
     * Проверка на ожидание в течение суток.
     * Если больше суток не опубликовано вернуть деньги. Перевести в state 7
     * @return void
     */
    public function accepted(TaskChannel $taskChannel)
    {
        if ($this->days($taskChannel) > 0) {
            $this->moneyBack($taskChannel);
            $this->setState($taskChannel, 8);
        }
    }

    /**
     * State 3
     * Рекламодатель подтвердил публикацию
     * регулярная проверка на соблюдение условий
     * @return void
     */
    public function published(TaskChannel $taskChannel)
    {
        $this->inProcess($taskChannel);
        $this->setState($taskChannel, 4);
    }


    /**
     * State 4
     * Задание в процессе
     * @return void
     */
    public function processing(TaskChannel $taskChannel)
    {
        $this->inProcess($taskChannel);
    }

    /**
     * State 5
     * Если задание выполнено
     * @return void
     */
    public function completed()
    {

    }

    /**
     * State 6
     * Если задание выполнено, но при этом был штраф
     * @return void
     */
    public function penalty()
    {

    }

    /**
     * State 7
     * Отказался учавствовать
     * @return void
     */
    public function refused()
    {

    }


    /**
     * State 7
     * Превышено время ожидания ответа или размещения
     * @return void
     */
    public function exceeded()
    {

    }


    public function inProcess(TaskChannel $taskChannel) {

        // Проверка соблюдения тишины
        $this->silence($taskChannel);
        // Проверка соблюдения времени публикации
        $this->startEndCheck($taskChannel);

    }

    public function silence(TaskChannel $channelTask)
    {
        if($channelTask->tgstat_post && is_null($channelTask->penalty)) {
            $between = [
                $channelTask->tgstat_post->date,
                $channelTask->tgstat_post->date + ($channelTask->task->silence * $this->hour)
            ];
            $tasks = TgstatPost::where('channel_id',$channelTask->channel_id)
                ->whereBetween('date',$between)
                ->where('post_id','!=', $channelTask->tgstat_post->post_id)
                ->get();
            if(count($tasks)) {
                $this->penaltyTransfer($channelTask);
            }
        }

    }

    public function startEndCheck(TaskChannel $channelTask)
    {
        if($channelTask->tgstat_post && $channelTask->tgstat_post->is_deleted) {

            $duration = $channelTask->tgstat_post->deleted_at - $channelTask->tgstat_post->date;
            dump($duration);

            if(in_array($channelTask->price_type, $this->daily)) {
                if($duration >= $this->day ) {
                    $this->moneyTransfer($channelTask);
                } else {
                    $this->moneyTransfer($channelTask, config('app.penalty_schedule'));
                }
            }

            if(in_array($channelTask->price_type, $this->twoDaily)) {
                if($duration >= ($this->day * 2) ) {
                    $this->moneyTransfer($channelTask);
                } else {
                    $this->moneyTransfer($channelTask, config('app.penalty_schedule'));
                }
            }

            $this->setState($channelTask, 5);
        }

    }

    public function moneyBack(TaskChannel $taskChannel)
    {
        $user = User::where('id', $taskChannel->user_id)->first();
        $user->balance = (int)$user->balance + (int)$taskChannel->price;
        $user->save();
        dump($user->balance);
    }

    public function moneyTransfer(TaskChannel $taskChannel, $penalty = 0)
    {
        $channel = Channel::where('id', $taskChannel->channel_id)->first();
        $user = User::where('id', $channel->owner_id)->first();
        $user->balance = (int)$user->balance + $this->percent($taskChannel->price) - $penalty;
        $user->save();
        dump('ee',$this->percent($taskChannel->price) - $penalty);
    }

    public function penaltyTransfer(TaskChannel $taskChannel)
    {
        $channel = Channel::where('id', $taskChannel->channel_id)->first();
        $owner = User::where('id', $channel->owner_id)->first();
        $owner->balance =  (int)$owner->balance - config('app.penalty_silence');
        $owner->save();

        $taskChannel->penalty = config('app.penalty_silence');
        $taskChannel->save();

        $advertiser =  User::where('id', $taskChannel->user_id)->first();
        $advertiser->balance =  (int)$advertiser->balance + config('app.penalty_silence');
        $advertiser->save();

        $this->setState($taskChannel,6);
    }


    private function days(TaskChannel $taskChannel): int
    {
        return Carbon::now()->diffInDays(Carbon::parse($taskChannel->created_at));
    }

    private function setState(TaskChannel $taskChannel, int $state)
    {
        $taskChannel->state = $state;
        $taskChannel->save();
    }

    private function percent($int) {
        return (int)$int * ((100 - config('app.fee_percent'))/100);
    }


}
