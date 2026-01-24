<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\MessageTone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $message
 * @property MessageTone $tone
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
final class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'message' => $this->message,
            'tone' => $this->tone->label(),
        ];
    }
}
