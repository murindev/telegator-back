<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task\TaskChannel;
use App\Services\Api\ApiAnswerService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \App\Models\User
     */
    public function info(Request $request){
        $user = \Auth::user();
        $user['fee'] = (int)config('app.fee_percent',15);
        return $user;
    }


    public function taskStates() {
        return TaskChannel::with()->where('',);
    }

    public function balance() {
        $user = \Auth::user();
        return [
            'balance' => $user->balance,
            'hold' => $user->hold,
            'fee_percent' => config('app.fee_percent',15)
        ];
    }

}
