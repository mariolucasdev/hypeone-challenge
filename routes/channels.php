<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('chat.{chatId}', function () {
    return true;
});

Broadcast::channel('chats.{chatId}', function () {
    return true;
});

Broadcast::channel('messages.{chatId}', function () {
    return true;
});

Broadcast::channel('private-messages.{chatId}', function () {
    return true;
});

// Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });
