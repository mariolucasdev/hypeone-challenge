<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ChatTest extends TestCase
{

    public function test_the_start_new_chat(): void
    {
        $user = (array) User::find(1);
        Auth::attempt($user);

        $chatData = [
            'title' => 'Test Passed',
            'username' => 'Mário Lucas',
        ];

        $response = $this->post('/api/chat', $chatData);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('username')
                ->has('title')
                ->has('id')
                ->has('created_at')
                ->has('updated_at')
        );

        $response->assertStatus(201);
    }

    public function test_faild_start_chat(): void
    {
        // Missing title param
        $chatData = [
            'username' => 'Mário Lucas',
        ];

        $response = $this->post('/api/chat/', $chatData);
        $response->assertStatus(302);
    }

    public function test_close_chat(): void
    {
        $response = $this->put('/api/chat/1/close');
        $response->assertStatus(200);
    }

    public function test_failed_close_status(): void
    {
        // Chat with id 1000 not exists
        $response = $this->put('/api/chat/1000/close');
        $response->assertStatus(404);
    }

    public function test_get_chat_details(): void
    {
        $response = $this->get('/api/chat/1/details');
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('id')
                ->has('title')
                ->has('username')
                ->has('closed')
                ->has('created_at')
                ->has('updated_at')
        );

        $response->assertStatus(200);
    }

    public function test_fail_get_chat_details(): void
    {
        // Added not exists id
        $response = $this->get('/api/chat/10000/details');
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('error')
        );

        $response->assertStatus(404);
    }
}
