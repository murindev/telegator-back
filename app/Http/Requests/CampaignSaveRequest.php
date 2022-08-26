<?php

namespace App\Http\Requests;

use App\Rules\AfterNowPlus;
use App\Rules\TimeInterval;
use Illuminate\Foundation\Http\FormRequest;

class CampaignSaveRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'required',
                'string'
            ],
            'range.start_dts' => [
                'required',
                'date',
                new AfterNowPlus(config('telegator.campaign.hold_before_publication_start'))
            ],
            'range.end_dts' => [
                'required',
                'date',
                'after:range.start_dts'
            ],
            'range' => [
                new TimeInterval(config('telegator.campaign.hold_between_publication_start_and_end'))
            ]
        ];
    }

    public function attributes()
    {
        return [
            'range.start_dts' => 'start range',
            'range.end_dts' => 'end range',
        ];
    }
}
