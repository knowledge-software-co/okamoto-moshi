<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\AuthorTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class PrefectureRegion extends Model
{
    use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use AuthorTrait;
    use Cachable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'name_kana',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
    ];
}
