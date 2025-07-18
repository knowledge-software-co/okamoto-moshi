<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/02/14
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sequence extends Model
{
    // 定数を最初に配置 (constant_public)
    // 独自コネクション名
    // ※ここでしか使わないからあえて config に書かない
    public const DB_CONNECTION = 'mysql_sequence';

    // public プロパティを先に配置 (property_public)
    // タイムスタンプなし
    public $timestamps = false;

    // 次に protected プロパティを配置 (property_protected)
    // 独自コネクション
    protected $connection = self::DB_CONNECTION;

    // プライマリキー
    protected $primaryKey = 'key';

    // protected static メソッドを最後に配置 (method_protected_static)
    protected static function boot()
    {
        parent::boot();

        // デフォルトコネクションをコピーして独自コネクションを作る
        config(['database.connections.' . self::DB_CONNECTION =>
            config('database.connections.' . config('database.default')),
        ]);
    }

    /**
     * 会社に関連するデータを取得
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
