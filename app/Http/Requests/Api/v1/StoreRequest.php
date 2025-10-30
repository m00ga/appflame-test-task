<?php

namespace App\Http\Requests\Api\v1;

use App\Enum\EventTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', Rule::enum(EventTypeEnum::class)],
            'ts' => ['required', 'date'],
            'session_id' => ['required', 'uuid:4']
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
