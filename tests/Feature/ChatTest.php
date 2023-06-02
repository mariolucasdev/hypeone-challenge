<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ChatTest extends TestCase
{

    public function test_shold_create_a_new_chat_expect_code_201(): void
    {
        Auth::loginUsingId(1);

        $chatData = [
            'title' => 'Test Passed',
            'username' => 'Mário Lucas',
        ];

        $response = $this->post('/api/chat', $chatData);
        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->has('id')
                ->has('title')
                ->has('username')
                ->has('created_at')
                ->has('updated_at')
        );

        $response->assertStatus(201);
    }

    public function test_shold_receive_error_302_becouse_missed_param(): void
    {
        Auth::loginUsingId(1);

        $response = $this->post('/api/chat/', [
            'username' => 'Mário Lucas',
        ]);
        $response->assertStatus(302);
    }

    public function test_close_chat_expected_code_200(): void
    {
        Auth::loginUsingId(1);

        $response = $this->put('/api/chat/2/close');
        $response->assertStatus(200);
    }

    public function test_shold_receive_error_404_becouse_chat_not_exists(): void
    {
        Auth::loginUsingId(1);

        $response = $this->put('/api/chat/1000/close');
        $response->assertStatus(404);
    }

    public function test_shold_get_chat_details_expect_code_200(): void
    {
        $response = $this->get('/api/chat/1/details');
        $response->assertStatus(200);
    }

    public function test_shold_get_chat_details_expect_code_correctly_json_structure(): void
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
    }

    public function test_shold_fail_becouse_chat_not_exists_expect_404_code(): void
    {
        // Added not exists id
        $response = $this->get('/api/chat/10000/details');
        $response->assertStatus(404);
    }
}
