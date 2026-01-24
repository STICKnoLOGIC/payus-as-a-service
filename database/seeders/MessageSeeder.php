<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Seeder;

class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Reads messages from JSON file and seeds database
     */
    public function run(): void
    {
        $jsonPath = base_path('messages.json');
        
        if (!file_exists($jsonPath)) {
            $this->command->error('messages.json file not found!');
            return;
        }
        
        $jsonContent = file_get_contents($jsonPath);
        $messages = json_decode($jsonContent, true);
        
        if (!$messages) {
            $this->command->error('Failed to parse messages.json!');
            return;
        }
        
        $this->command->info('Seeding ' . count($messages) . ' messages...');
        
        foreach ($messages as $messageData) {
            Message::create([
                'message' => $messageData['message'],
                'tone' => $messageData['tone'],
            ]);
        }
        
        $this->command->info('Successfully seeded messages!');
    }
}
