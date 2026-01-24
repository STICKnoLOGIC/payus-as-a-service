<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Enums\MessageTone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class GetMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'tone' => [
                'sometimes',
                'string',
                Rule::in(['professional', 'playful', 'friendly', 'frank', 'funny']),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'tone.in' => 'The tone must be one of: professional, playful, friendly, frank, or funny.',
        ];
    }

    public function getTone(): ?MessageTone
    {
        if (!$this->has('tone')) {
            return null;
        }

        return MessageTone::fromString($this->string('tone')->toString());
    }
}
