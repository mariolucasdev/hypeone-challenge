<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_get_chat_messages(): void
    {
        $response = $this->get('/api/message/1');
        $response->assertJsonIsArray();
        $response->assertStatus(200);
    }

    public function test_store_chat_message(): void
    {
        $messageData = [
            "chat_id" => 1,
            "content" => "Test Passed",
            "username" => "Mário Lucas"
        ];

        $response = $this->post('/api/message/store', $messageData);
        $response->assertStatus(201);
    }
}
