<?php

namespace App\Http\Requests;

use App\Exceptions\ThrottleException;
use App\Models\Reply;
use App\Rules\SpamFree;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use App\Rules\Recaptcha;

class CreateReplyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('create', new Reply);
    }

    protected function failedAuthorization()
    {
        throw new ThrottleException('You are replying too much. Take a break');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', new SpamFree],
            'g-recaptcha-response' => ['required',  app(Recaptcha::class)]
        ];
    }
}
