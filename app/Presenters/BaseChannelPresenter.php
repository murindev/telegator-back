<?php


namespace App\Presenters;


use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class BaseChannelPresenter extends Presenter
{
    public $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function avgCoveragePrice()
    {
        return $this->model->channelStats->avg_coverage / $this->model->price;
    }

    public function er()
    {
        if ($this->model->channelStats->avg_coverage === 0 || $this->model->actualSubscribersCount->count() === 0) {
            return 0;
        }
        return $this->model->channelStats->avg_coverage / $this->model->actualSubscribersCount[0]->count;
    }

    public function subscribersCount()
    {
        if($this->model->actualSubscribersCount->count() !== 0) {
            return $this->model->actualSubscribersCount[0]->count;
        }

        return 0;
    }
}
