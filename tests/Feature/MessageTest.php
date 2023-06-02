<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MessageTest extends TestCase
{
    public function test_shold_get_chat_messages_expect_code_200(): void
    {
        $response = $this->get('/api/message/1');
        $response->assertStatus(200);
    }

    public function test_shold_create_a_new_message(): void
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
