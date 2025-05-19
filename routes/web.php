<?php

use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'user' => User::whereNot('id', Auth::id())->get()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('chat/{friend}', function (User $friend) {
    return Inertia::render('Chat', [
        'friend' => $friend,
        'currentUser' => Auth::user()
    ]);
})->middleware(['auth'])->name('chat');

Route::get('messages/{friend}', function (User $friend) {
    return ChatMessage::query()->where(
        function ($query) use ($friend) {
            $query->where('sender_id', Auth::id())->orWhere('reciver_id', $friend->id);
        }
    )->orwhere(function ($query) use ($friend) {
        $query->where('sender_id', $friend->id)->orWhere('reciver_id', Auth::id());
    })
        ->with(['sender', 'reciver'])
        ->get();
});

Route::post('messages/{friend}', function (User $friend) {
    $message = ChatMessage::create([
        'sender_id' => Auth::id(),
        'reciver_id' => $friend->id,
        'text' => request('message')
    ]);
    return $message;
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
