<?php

namespace App\Http\Requests;

use App\Rules\Recaptcha;
use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;

class CreateThreadRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'channel_id' => ['required','exists:channels,id'],
            'title' => ['required', new SpamFree],
            'body' => ['required', new SpamFree],
            'g-recaptcha-response' => ['required',  app(Recaptcha::class)]
        ];
    }
}
