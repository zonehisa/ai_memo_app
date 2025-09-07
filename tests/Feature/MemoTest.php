<?php

declare(strict_types=1);

use App\Models\Memo;
use App\Models\User;
use Livewire\Volt\Volt;

describe('メモ管理機能', function () {
    beforeEach(function () {
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
    });

    describe('メモ一覧画面', function () {
        test('認証済みユーザーがメモ一覧画面にアクセスできる', function () {
            $response = $this->get(route('memos.index'));

            $response->assertStatus(200);
            $response->assertSee('メモ一覧');
            $response->assertSee('新規作成');
        });

        test('ユーザー自身のメモのタイトルが表示される', function () {
            // テストデータ作成
            $memo1 = Memo::factory()->create([
                'user_id' => $this->user->id,
                'title' => 'テストメモ1',
                'body' => 'テスト内容1',
            ]);

            $memo2 = Memo::factory()->create([
                'user_id' => $this->user->id,
                'title' => 'テストメモ2',
                'body' => 'テスト内容2',
            ]);

            // 他のユーザーのメモ（表示されないはず）
            $otherUser = User::factory()->create();
            Memo::factory()->create([
                'user_id' => $otherUser->id,
                'title' => '他人のメモ',
                'body' => '他人の内容',
            ]);

            $response = $this->get(route('memos.index'));

            $response->assertSee('テストメモ1');
            $response->assertSee('テストメモ2');
            $response->assertDontSee('他人のメモ');
        });

        test('メモがない場合、空の状態メッセージが表示される', function () {
            $response = $this->get(route('memos.index'));

            $response->assertSee('メモがありません');
            $response->assertSee('最初のメモを作成してみましょう');
        });

        test('メモタイトルをクリックすると詳細画面に遷移する', function () {
            $memo = Memo::factory()->create([
                'user_id' => $this->user->id,
                'title' => 'テストメモ',
                'body' => 'テスト内容',
            ]);

            $response = $this->get(route('memos.index'));

            $response->assertSee(route('memos.show', $memo));
        });
    });

    describe('メモ作成画面', function () {
        test('認証済みユーザーがメモ作成画面にアクセスできる', function () {
            $response = $this->get(route('memos.create'));

            $response->assertStatus(200);
            $response->assertSee('新しいメモを作成');
            $response->assertSee('タイトル');
            $response->assertSee('本文');
        });

        test('有効なデータでメモを作成できる', function () {
            Volt::test('memos.create')
                ->set('title', 'テストタイトル')
                ->set('body', 'テスト本文')
                ->call('save')
                ->assertRedirect(route('memos.index'));

            // データベースにメモが保存されているか確認
            $this->assertDatabaseHas('memos', [
                'user_id' => $this->user->id,
                'title' => 'テストタイトル',
                'body' => 'テスト本文',
            ]);
        });

        describe('バリデーション', function () {
            test('タイトルが必須', function () {
                Volt::test('memos.create')
                    ->set('title', '')
                    ->set('body', 'テスト本文')
                    ->call('save')
                    ->assertHasErrors(['title' => 'required']);
            });

            test('タイトルが50文字以下', function () {
                $longTitle = str_repeat('あ', 51);

                Volt::test('memos.create')
                    ->set('title', $longTitle)
                    ->set('body', 'テスト本文')
                    ->call('save')
                    ->assertHasErrors(['title' => 'max']);
            });

            test('本文が必須', function () {
                Volt::test('memos.create')
                    ->set('title', 'テストタイトル')
                    ->set('body', '')
                    ->call('save')
                    ->assertHasErrors(['body' => 'required']);
            });

            test('本文が2000文字以下', function () {
                $longBody = str_repeat('あ', 2001);

                Volt::test('memos.create')
                    ->set('title', 'テストタイトル')
                    ->set('body', $longBody)
                    ->call('save')
                    ->assertHasErrors(['body' => 'max']);
            });

            test('境界値テスト - タイトル50文字ちょうど', function () {
                $title = str_repeat('あ', 50);

                Volt::test('memos.create')
                    ->set('title', $title)
                    ->set('body', 'テスト本文')
                    ->call('save')
                    ->assertHasNoErrors()
                    ->assertRedirect(route('memos.index'));
            });

            test('境界値テスト - 本文2000文字ちょうど', function () {
                $body = str_repeat('あ', 2000);

                Volt::test('memos.create')
                    ->set('title', 'テストタイトル')
                    ->set('body', $body)
                    ->call('save')
                    ->assertHasNoErrors()
                    ->assertRedirect(route('memos.index'));
            });
        });

        test('作成後にセッションメッセージが設定される', function () {
            Volt::test('memos.create')
                ->set('title', 'テストタイトル')
                ->set('body', 'テスト本文')
                ->call('save')
                ->assertRedirect(route('memos.index'))
                ->assertSessionHas('message', 'メモを作成しました。');
        });
    });
});
