<?php

declare(strict_types=1);

describe('メモ管理機能の認証テスト', function () {
    test('未認証ユーザーはメモ一覧画面にアクセスできない', function () {
        $response = $this->get(route('memos.index'));

        $response->assertRedirect(route('login'));
    });

    test('未認証ユーザーはメモ作成画面にアクセスできない', function () {
        $response = $this->get(route('memos.create'));

        $response->assertRedirect(route('login'));
    });
});
