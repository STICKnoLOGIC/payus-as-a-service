<?php

declare(strict_types=1);

namespace App\Enums;

enum MessageTone: int
{
    case PROFESSIONAL = 0;
    case PLAYFUL = 1;
    case FRIENDLY = 2;
    case FRANK = 3;
    case FUNNY = 4;

    public static function fromString(string $tone): ?self
    {
        return match (mb_strtolower($tone)) {
            'professional' => self::PROFESSIONAL,
            'playful' => self::PLAYFUL,
            'friendly' => self::FRIENDLY,
            'frank' => self::FRANK,
            'funny' => self::FUNNY,
            default => null,
        };
    }

    /**
     * @return array<string, string>
     */
    public static function labels(): array
    {
        return [
            'professional' => 'Professional',
            'playful' => 'Playful',
            'friendly' => 'Friendly',
            'frank' => 'Frank',
            'funny' => 'Funny',
        ];
    }

    public function label(): string
    {
        return match ($this) {
            self::PROFESSIONAL => 'Professional',
            self::PLAYFUL => 'Playful',
            self::FRIENDLY => 'Friendly',
            self::FRANK => 'Frank',
            self::FUNNY => 'Funny',
        };
    }
}
