<?php

namespace App\Http\Requests;

use App\Models\Post\PostPriceType;
use App\Rules\ExistArrayIdSelected;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AddChannelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'prices' => $this->prices(),
            'price' => 1,
            'author_post' => $this->creatingAuthorsPost ? 1 : 0
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'tg_link' => ['required', 'string', 'regex:/https:\/\/t.me\/[a-zA-Z0-9+-_]+/', 'unique:App\Models\Channel,tg_link'],
            'prices' => [],
            'contact_tg' => ['required', 'string', 'regex:/https:\/\/t.me\/[a-zA-Z0-9+-_]+/'],
            'contact' => ['required',  'string'],
            'categories' => ['required', 'array', new ExistArrayIdSelected('App\Models\Category')],
            'categories.*' => ['required', 'integer'],
            'author_post' => ''
        ];
    }


    public function prices(): array
    {
        $result = [];
        foreach ($this->request->get('prices') as $key => $value) if($value) {

            if($type = PostPriceType::where('name', $key)->first()) {
                $item = [];
                $item['post_price_type_id'] = $type->id;
                $item['price'] =  $value;
                $result[] = collect($item);
            }
        }
        return $result;
    }
}
