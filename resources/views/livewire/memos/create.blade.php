<?php

use function Livewire\Volt\{state, rules, mount};
use App\Models\Memo;

// 状態定義
state([
    'title' => '',
    'body' => '',
]);

// バリデーションルール
rules([
    'title' => 'required|max:50',
    'body' => 'required|max:2000',
]);

// 作成処理
$save = function () {
    // バリデーション実行
    $this->validate();

    // メモ作成
    Memo::create([
        'user_id' => auth()->id(),
        'title' => $this->title,
        'body' => $this->body,
    ]);

    // 成功メッセージ
    session()->flash('message', 'メモを作成しました。');

    // メモ一覧画面にリダイレクト
    return redirect()->route('memos.index');
};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- ヘッダー -->
                <div class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">
                        新しいメモを作成
                    </h1>
                </div>

                <!-- 成功メッセージ -->
                @if (session('message'))
                    <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- フォーム -->
                <form wire:submit="save" class="space-y-6">
                    <!-- タイトル入力 -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            タイトル
                            <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="title" wire:model="title"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('title') border-red-500 @enderror"
                            placeholder="メモのタイトルを入力してください" maxlength="50" />

                        <!-- タイトル文字数カウンター -->
                        <div class="mt-1 flex justify-between items-center">
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-sm text-gray-500">
                                {{ strlen($title) }}/50文字
                            </span>
                        </div>
                    </div>

                    <!-- 本文入力 -->
                    <div>
                        <label for="body" class="block text-sm font-medium text-gray-700 mb-2">
                            本文
                            <span class="text-red-500">*</span>
                        </label>
                        <textarea id="body" wire:model="body" rows="10"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('body') border-red-500 @enderror"
                            placeholder="メモの内容を入力してください" maxlength="2000"></textarea>

                        <!-- 本文文字数カウンター -->
                        <div class="mt-1 flex justify-between items-center">
                            @error('body')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @else
                                <span></span>
                            @enderror
                            <span class="text-sm text-gray-500">
                                {{ strlen($body) }}/2000文字
                            </span>
                        </div>
                    </div>

                    <!-- ボタン群 -->
                    <div class="flex items-center justify-between border-t pt-6">
                        <!-- キャンセルボタン -->
                        <a href="{{ route('memos.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 focus:bg-gray-400 active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            キャンセル
                        </a>

                        <!-- 作成ボタン -->
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 disabled:opacity-50"
                            wire:loading.attr="disabled">
                            <span wire:loading.remove>作成</span>
                            <span wire:loading>作成中...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
