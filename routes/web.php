<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'webrtc');

Route::post('pusher/auth', function() {
    $socketId = request()->socket_id;
    $channel = request()->channel_name;
    $presenceData = [
        'user_id' => Str::random(12) . now()->timestamp,
    ];

    $config = config('broadcasting.connections.pusher');

    $pusher = new Pusher\Pusher(
        $config['key'],
        $config['secret'],
        $config['app_id'],
        $config['options']
    );

    return ($pusher->presence_auth($channel, $socketId, $presenceData['user_id']));
});
