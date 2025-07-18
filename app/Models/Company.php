<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/04
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use App\Traits\AuthorTrait;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Company extends Model
{
    use HasFactory;
    use Notifiable;
    use AuthorTrait;
    use Cachable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'representative',
        'phone',
        'address',
        'comment',
        'advertising_payment_date',
        'point',
        'is_paid',
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
     * この会社に紐づくユーザー
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * この会社のシーケンス
     */
    public function sequence(): HasOne
    {
        return $this->hasOne(Sequence::class);
    }
}
