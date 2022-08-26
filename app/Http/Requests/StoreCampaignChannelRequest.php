<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignChannelRequest extends FormRequest
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


    public function prepareForValidation()
    {
        $range = $this->request->get('range');

        $this->merge([
            'range_start_at' => $range['start_dts'],
            'range_end_at' => $range['end_dts'],
            'campaign_id' => $this->request->get('campaign_id') ?? null,
            'user_id' => \Auth::id(),

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
            'user_id' => 'required|numeric',
            'description' => '',
            'title' => 'required',
            'range_start_at' => 'required|date|after:now',
            'range_end_at' => 'required|date|after:now',
        ];
    }


    public function messages(): array
    {
        return [
            'range_start_at.after' => 'Дата начала кампании должна быть больше текущей даты',
            'range_end_at.after' => 'Дата окончания кампании должна быть больше текущей даты и длиться хотя бы один день',
        ];
    }


    public function attributes(): array
    {
        return [
            'range_start_at' => '"Начало кампании"'.PHP_EOL,
            'range.end_dts' => '"Конец кампании"'.PHP_EOL,
        ];
    }
}
