<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Memo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemoSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 最初のユーザーを取得（存在しない場合は作成）
        $user = User::first() ?? User::factory()->create();

        // サンプルメモデータを作成
        $memos = [
            [
                'id' => 1,
                'title' => 'PHP',
                'body' => 'PHPは、Hypertext Preprocessorの略です。',
            ],
            [
                'id' => 2,
                'title' => 'HTML',
                'body' => 'HTMLは、Hypertext Markup Languageの略です。',
            ],
            [
                'id' => 3,
                'title' => 'CSS',
                'body' => "CSSは、\nCascading Style Sheets\nの略です。",
            ],
            [
                'id' => 4,
                'title' => '混在',
                'body' => "Test123 てすとアイウエオｱｲｳｴｵ\n漢字！ＡＢＣ ａｂｃ １２３   😊✨",
            ],
        ];

        foreach ($memos as $memoData) {
            Memo::create([
                'user_id' => $user->id,
                'title' => $memoData['title'],
                'body' => $memoData['body'],
            ]);
        }
    }
}
