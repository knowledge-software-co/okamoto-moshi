<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\AuthorTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Prefecture extends Model
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
        'prefecture_region_id',
        'name',
        'name_kana',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
    ];

    /**
     * for eager loading
     */
    protected $with = [
        'prefectureRegion',
    ];

    protected $appends = [
        'modified_at',
        'created_at_formated',
        'created_at_formated_only_date',
        'updated_at_formated',
        'updated_at_formated_only_date',
        'deleted_at_formated',
        'deleted_at_formated_only_date',
    ];

    protected $casts = [
        'modified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'created_at_formated' => 'datetime',
        'created_at_formated_only_date' => 'datetime',
        'updated_at_formated' => 'datetime',
        'updated_at_formated_only_date' => 'datetime',
        'deleted_at_formated' => 'datetime',
        'deleted_at_formated_only_date' => 'datetime',
    ];

    /**
     * この都道府県に紐づく地方
     */
    public function prefectureRegion(): BelongsTo
    {
        return $this->belongsTo(PrefectureRegion::class);
    }

    /**
     * このユーザーに紐づく住所
     */
    public function userLocations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }
}
