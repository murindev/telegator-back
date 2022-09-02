<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'id' => request('id') ?? null,
            'user_id' => auth()->id(),
            'range_start_at' => $this->date_start.' '.$this->time_start.':00',
            'range_end_at' => $this->date_end.' '.$this->time_end.':00',
            'status' => request('status') ?? 1,
            'author_post' => $this->request->get('author_post') ? 1 : 0 // creatingAuthorsPost
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
            'id' => '',
            'user_id' => 'required|numeric',
//            'campaign_id' => '',
//            'channels' => 'required|array',
            'title' => 'required',
            'text' => 'required',
            'status' => 'required|numeric',
            'duration' => '',
            'silence' => '',
//            'prices' => 'required',
            'range_start_at' => 'required|date|after:now',
            'range_end_at' => 'required|date|after:now',
            'author_post' => ''
        ];
    }

}
