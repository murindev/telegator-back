<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddChannelRequest;
use App\Models\Category;
use App\Models\Channel;
use App\Models\ChannelsList;
use App\Models\Claim;
use App\Presenters\BaseChannelPresenter;
use App\Services\Tme\TmeParser;
use App\Services\Tme\TmeService;
use App\Utils\Checker;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use App\Services\Api\ApiAnswerService;
use Symfony\Component\DomCrawler\Crawler;

class ChannelController extends Controller
{
    public function index(Channel $channel) {
        return $this->getList($channel);
    }

    public function byOwner(Channel $channel) {
        return $channel->byOwner();
    }

    public function categories(Category $category) {
        return $category->all();
    }



    public function getChannel($id, Channel $channel){
        return $channel->channel($id);
    }
    public function getAll(Channel $channel, Category $category)
    {
        return [
            'channels' => $this->getList($channel),
            'categories' => $category->all()
        ];
//        $channels = $channel->index();

/*        foreach ($channels as &$channel) {
            $presenter = new BaseChannelPresenter($channel);
            $channel->er = $presenter->er();
            $channel->subcribers_count = $presenter->subscribersCount();
            $channel->avg_coverage_price = $presenter->avgCoveragePrice();
            $channel->avg_coverage = $channel->channelStats->avg_coverage;
            unset($channel->channelStats);
            unset($channel->actualSubscribersCount);
        }*/

//        return ApiAnswerService::successfulAnswerWithData($channels);

    }

    public function getList(Channel $channel) {
        return $channel->index();
    }

//    public function getListByOwner(Channel $channel) {
//        return $channel->index();
//    }

    public function search(Request $request): JsonResponse
    {
        $data = $request->validate([
            'search' => ['nullable', 'string'],
            'categoriesIds' => ['nullable', 'array'],
            'excludeIds' => ['nullable', 'array'],
            'subsFrom' => ['nullable', 'integer'],
            'subsTo' => ['nullable', 'integer'],
            'priceFrom' => ['nullable', 'integer'],
            'priceTo' => ['nullable', 'integer'],
            'reachFrom' => ['nullable', 'integer'],
            'reachTo' => ['nullable', 'integer'],
            'reachPriceFrom' => ['nullable', 'integer'],
            'reachPriceTo' => ['nullable', 'integer'],
        ]);

        $b = [];

        if (Checker::isNullableArray($data)) {
            $data = Channel::all();
        } else {
            $builder = Channel::query();

            if ($data['search']) {
                $b['search'] = $data['search'];
                $builder->where('title', 'like', "%${data['search']}%");
            }

            if ($data['excludeIds']) {
                $b['excludeIds'] = $data['excludeIds'];
                $builder->whereNotIn('id', $data['excludeIds']);
            }

            if ($data['categoriesIds']) {
                $catIds = $data['categoriesIds'];
                $b['categoriesIds'] = $data['categoriesIds'];
                $builder->whereExists(function ($query) use ($catIds) {
                    $channelTableName = app(Channel::class)->getTable();
                    $query->select(\DB::raw(1))
                        ->from('category_channel')
                        ->whereColumn('category_channel.channel_id', "$channelTableName.id")
                        ->whereIn('category_channel.category_id', $catIds);
                });
            }

            $b['SQL'] = $builder->toSql();
            $data = $builder->get();
        }

        $data->makeVisible([
            'members_count',
            'reach_avg',
            'er',
            'cpu',
            'index',
            'categories_labels'
        ]);

        return response()->json(['channels' => $data,
            'request' => $request->toArray(),
            'builder' => $b,
        ]);
    }

    public function claim(Request $request)
    {
        $data = $request->validate([
            'categoriesIds' => ['required', 'array'],
            'price' => ['required', 'numeric', 'min:0'],
            'contact' => ['string'],
            'link' => ['required', 'string', function ($attribute, $value, $fail) {
                if (!TmeService::channelExists($value)) {
                    $fail("$attribute must be valid link to channel");
                }
            }],
        ]);

        if (count($data['categoriesIds']) !== Category::whereIn('id', $data['categoriesIds'])->count()) {
            throw ValidationException::withMessages(['categories' => ['Undefined category']]);
        }

        $info = TmeService::getChannelSlugInfoOrFalse($data['link']);
        $channel = Channel::where('slug', $info->slug)->first();

        if ($channel && $channel->owner_id) {
            throw ValidationException::withMessages(['channel' => ['This channel already has an owner.']]);
        }

//        if ($claim = Claim::where([]))

        $claim = Claim::create([
            'user_id' => \Auth::id(),
            'channel_id' => $channel ? $channel->id : null,
            'price' => $data['price'],
            'contacts' => Arr::get($data, 'contact'),
            'link' => $data['link'],
            'cat_ids' => $data['categoriesIds'],
            'result' => null,
        ]);

        return response()->json(['claim' => $claim]);
    }

    public function add(AddChannelRequest $request, Channel $channel)
    {
        $channel = $channel->addChannel($request);
        return ApiAnswerService::successfulAnswer();
    }


    public function parseHttpTg(){
        $r = explode('/','https://t.me/montyan2');
        $name = array_pop($r);
        $rp = TmeParser::fetchChannelInfo($name);
        $contents = file_get_contents($rp->image);
       $st = \Storage::put('/public/avatars/channels/'.$name.'.jpg', $contents);

        return json_encode($st);
    }


}
