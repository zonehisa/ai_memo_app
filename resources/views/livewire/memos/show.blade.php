<?php

use function Livewire\Volt\{state, mount};
use App\Models\Memo;

// 状態定義
state(['memo']);

// 初期化処理
mount(function (Memo $memo) {
    // ルートモデルバインディングでMemoインスタンスを受け取る
    $this->memo = $memo;

    // 認可チェック - ユーザーが自分のメモのみアクセス可能
    if ($memo->user_id !== auth()->id()) {
        abort(403, 'このメモにアクセスする権限がありません。');
    }
});

// 削除処理
$delete = function () {
    // 認可チェック
    if ($this->memo->user_id !== auth()->id()) {
        abort(403);
    }

    // メモ削除
    $this->memo->delete();

    // 成功メッセージ
    session()->flash('message', 'メモを削除しました。');

    // メモ一覧画面にリダイレクト
    return redirect()->route('memos.index');
};

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- メモタイトル -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">
                    {{ $memo->title }}
                </h1>

                <!-- 作成日 -->
                <div class="text-sm text-gray-500 mb-6">
                    作成日: {{ $memo->created_at->format('Y年m月d日 H:i') }}
                </div>

                <!-- メモ本文 -->
                <div class="prose max-w-none">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-gray-800 whitespace-pre-wrap leading-relaxed">{{ $memo->body }}</p>
                    </div>
                </div>

                <!-- アクションボタン群 -->
                <div class="mt-8 border-t pt-6">
                    <div class="flex items-center justify-between">
                        <!-- 戻るボタン -->
                        <a href="{{ route('memos.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            ← 戻る
                        </a>

                        <!-- 編集・削除ボタン -->
                        <div class="flex items-center space-x-3">
                            <!-- 編集ボタン -->
                            <a href="{{ route('memos.edit', $memo) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                編集
                            </a>

                            <!-- 削除ボタン -->
                            <button wire:click="delete" wire:confirm="本当にこのメモを削除しますか？"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                削除
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
