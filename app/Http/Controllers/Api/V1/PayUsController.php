<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Enums\MessageTone;
use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

final class PayUsController extends Controller
{
    use ApiResponse;

    /**
     * Get a random payment reminder message.
     *
     * @group PayUs
     */
    public function getRandom(): JsonResponse
    {
        return $this->getRandomMessage();
    }

    /**
     * Get random professional message.
     *
     * @group PayUs
     */
    public function getProfessional(): JsonResponse
    {
        return $this->getRandomMessage(MessageTone::PROFESSIONAL);
    }

    /**
     * Get random playful message.
     *
     * @group PayUs
     */
    public function getPlayful(): JsonResponse
    {
        return $this->getRandomMessage(MessageTone::PLAYFUL);
    }

    /**
     * Get random friendly message.
     *
     * @group PayUs
     */
    public function getFriendly(): JsonResponse
    {
        return $this->getRandomMessage(MessageTone::FRIENDLY);
    }

    /**
     * Get random frank message.
     *
     * @group PayUs
     */
    public function getFrank(): JsonResponse
    {
        return $this->getRandomMessage(MessageTone::FRANK);
    }

    /**
     * Get random funny message.
     *
     * @group PayUs
     */
    public function getFunny(): JsonResponse
    {
        return $this->getRandomMessage(MessageTone::FUNNY);
    }

    /**
     * Get available tones.
     *
     * @group PayUs
     */
    public function getTones(): JsonResponse
    {
        return $this->success([
            'tones' => MessageTone::labels(),
        ]);
    }

    /**
     * Get a random message, optionally filtered by tone.
     */
    private function getRandomMessage(?MessageTone $tone = null): JsonResponse
    {
        $query = Message::query();

        if ($tone instanceof MessageTone) {
            $query->where('tone', $tone);
        }

        $message = $query->inRandomOrder()->first();

        if (! $message) {
            return $this->notFound('No messages found for the specified criteria.');
        }

        return response()->json(new MessageResource($message));
    }
}
