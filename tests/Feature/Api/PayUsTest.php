<?php

declare(strict_types=1);

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    // Seed some test messages
    Message::factory()->create(['tone' => 0, 'message' => 'Professional message']);
    Message::factory()->create(['tone' => 1, 'message' => 'Playful message']);
    Message::factory()->create(['tone' => 2, 'message' => 'Friendly message']);
    Message::factory()->create(['tone' => 3, 'message' => 'Frank message']);
    Message::factory()->create(['tone' => 4, 'message' => 'Funny message']);
});

test('get random message without tone parameter returns any message', function () {
    $response = $this->getJson('/payus');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'message',
            'tone',
        ]);

    expect($response->json('message'))->toBeString();
    expect($response->json('tone'))->toBeString();
});

test('professional endpoint returns professional message', function () {
    $response = $this->getJson('/payus/professional');

    $response->assertStatus(200);
    expect($response->json('tone'))->toBe('Professional');
});

test('playful endpoint returns playful message', function () {
    $response = $this->getJson('/payus/playful');

    $response->assertStatus(200);
    expect($response->json('tone'))->toBe('Playful');
});

test('friendly endpoint returns friendly message', function () {
    $response = $this->getJson('/payus/friendly');

    $response->assertStatus(200);
    expect($response->json('tone'))->toBe('Friendly');
});

test('frank endpoint returns frank message', function () {
    $response = $this->getJson('/payus/frank');

    $response->assertStatus(200);
    expect($response->json('tone'))->toBe('Frank');
});

test('funny endpoint returns funny message', function () {
    $response = $this->getJson('/payus/funny');

    $response->assertStatus(200);
    expect($response->json('tone'))->toBe('Funny');
});

test('get tones returns all available tones', function () {
    $response = $this->getJson('/payus/tones');

    $response->assertStatus(200)
        ->assertJsonStructure([
            'success',
            'message',
            'data' => [
                'tones',
            ],
        ]);

    $tones = $response->json('data.tones');
    expect($tones)->toHaveKeys(['professional', 'playful', 'friendly', 'frank', 'funny']);
});