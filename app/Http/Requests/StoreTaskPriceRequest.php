<?php

namespace App\Http\Requests;

use App\Models\Post\PostPriceType;
use Illuminate\Foundation\Http\FormRequest;

class StoreTaskPriceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    protected function prepareForValidation(){
        $this->merge([
            'prices' => $this->priceIndexesArray($this->request->get('prices'))

        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'prices' => ''
        ];
    }

    public function priceIndexesArray($prices) : array {
        $arr = [];
        foreach ((array)$prices as $key => $price){
            if($price) {
                $arr[] = [
                    'post_price_type_id' => PostPriceType::where('name',$key)->first()->getAttribute('id'),
                    'price' => $price
                ];
            }
        }
        return $arr;
    }
}
