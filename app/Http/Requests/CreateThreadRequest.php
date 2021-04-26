<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Models\Thread;
use App\Rules\Recaptcha;
use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;
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
        // return Gate::allows('create', new Thread());
        return true;
    }

    // protected function failedAuthorization()
    // {
    //     throw new ThrottleException('You are replying too much. Take a break');
    // }

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
