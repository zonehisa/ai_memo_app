<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('settings.profile');
    Volt::route('settings/password', 'settings.password')->name('settings.password');
    Volt::route('settings/appearance', 'settings.appearance')->name('settings.appearance');

    // メモ関連画面
    Volt::route('memos', 'memos.index')->name('memos.index');
    Volt::route('memos/create', 'memos.create')->name('memos.create');
    Volt::route('memos/{memo}', 'memos.show')->name('memos.show');
    Volt::route('memos/{memo}/edit', 'memos.edit')->name('memos.edit');
});

require __DIR__ . '/auth.php';
