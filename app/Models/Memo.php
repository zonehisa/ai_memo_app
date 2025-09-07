<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * メモモデル
 * 
 * @property int $id 主キー
 * @property int $user_id ユーザーID
 * @property string $title メモのタイトル
 * @property string $body メモの本文
 * @property \Carbon\Carbon $created_at 作成日時
 * @property \Carbon\Carbon $updated_at 更新日時
 */
class Memo extends Model
{
    /**
     * 一括代入可能な属性
     * 
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'body',
    ];

    /**
     * キャストする属性
     * 
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * ユーザーとのリレーション（多対1）
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
