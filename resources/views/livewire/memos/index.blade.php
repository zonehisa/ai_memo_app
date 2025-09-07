<?php

use function Livewire\Volt\{state, mount, computed};
use App\Models\Memo;

// 状態定義
state(['memos']);

// 初期化処理
mount(function () {
    // 認証済みユーザーのメモを作成日の降順で取得
    $this->memos = Memo::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->get();
});

?>

<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <!-- ヘッダー -->
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-gray-900">
                        メモ一覧
                    </h1>

                    <!-- 新規作成ボタン -->
                    <a href="{{ route('memos.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        + 新規作成
                    </a>
                </div>

                @if ($memos->count() > 0)
                    <!-- メモ一覧 -->
                    <div class="space-y-4">
                        @foreach ($memos as $memo)
                            <div
                                class="bg-gray-50 border border-gray-200 rounded-lg p-4 hover:bg-gray-100 transition duration-150 ease-in-out">
                                <a href="{{ route('memos.show', $memo) }}" class="block">
                                    <div class="flex justify-between items-start">
                                        <!-- メモタイトル -->
                                        <h2
                                            class="text-lg font-semibold text-gray-900 hover:text-blue-600 transition duration-150 ease-in-out">
                                            {{ $memo->title }}
                                        </h2>

                                        <!-- 作成日 -->
                                        <span class="text-sm text-gray-500 ml-4 flex-shrink-0">
                                            {{ $memo->created_at->format('Y/m/d') }}
                                        </span>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- 空の状態 -->
                    <div class="text-center py-12">
                        <div class="max-w-md mx-auto">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">メモがありません</h3>
                            <p class="mt-1 text-sm text-gray-500">最初のメモを作成してみましょう。</p>
                            <div class="mt-6">
                                <a href="{{ route('memos.create') }}"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    + 新規作成
                                </a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- ダッシュボードへ戻るボタン -->
                <div class="mt-8 border-t pt-6">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        ← ダッシュボード
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
