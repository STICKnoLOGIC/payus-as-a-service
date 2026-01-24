<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

final class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Reads messages from JSON file and seeds database
     */
    public function run(): void
    {
        $jsonPath = base_path('messages.json');

        if (! file_exists($jsonPath)) {
            $this->command->error('messages.json file not found!');

            return;
        }

        $jsonContent = file_get_contents($jsonPath);
        if ($jsonContent === false) {
            $this->command->error('Failed to parse messages.json!');

            return;
        }

        $messages = json_decode($jsonContent, true);

        if (! $messages || ! is_array($messages)) {
            $this->command->error('Failed to parse messages.json!');

            return;
        }

        $this->command->info('Seeding '.count($messages).' messages...');

        foreach ($messages as $messageData) {
            if (! is_array($messageData)) {
                continue;
            }

            if (! isset($messageData['message'], $messageData['tone'])) {
                continue;
            }

            Message::query()->create([
                'message' => $messageData['message'],
                'tone' => $messageData['tone'],
            ]);
        }

        $this->command->info('Successfully seeded messages!');
    }
}
