<?php

namespace App\Models;

use App\Enums\Models\User\SexType;
use App\Traits\AuthorTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * プロフィールモデル
 * ユーザー・社員・エンジニアのプロフィール情報を一元管理
 * 各モデルとリレーション
 */
class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;
    use AuthorTrait;
    use Cachable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'last_name_kana',
        'first_name_kana',
        'date_of_birth',
        'sex_code',
        'email',
        'phone',
        'address',
        'postal_code',
        'prefecture',
        'city',
        'street_address',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'sex_code' => SexType::class,
        'deleted_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        'name',
        'name_kana',
        'sex_name',
        'birthday_formatted',
        'full_address',
    ];

    /**
     * このプロフィールに関連するユーザー
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    // /**
    //  * このプロフィールに関連するエンジニア
    //  */
    // public function engineer(): HasOne
    // {
    //     return $this->hasOne(Engineer::class);
    // }

    // /**
    //  * このプロフィールに関連する社員
    //  */
    // public function employee(): HasOne
    // {
    //     return $this->hasOne(Employee::class);
    // }

    /**
     * フルネームの取得
     */
    public function getNameAttribute(): string
    {
        return $this->last_name . ' ' . $this->first_name;
    }

    /**
     * フルネームカナの取得
     */
    public function getNameKanaAttribute(): string
    {
        return $this->last_name_kana . ' ' . $this->first_name_kana;
    }

    /**
     * 性別名の取得
     */
    public function getSexNameAttribute(): string
    {
        return $this->sex_code->label();
    }

    /**
     * 生年月日をハイフン区切りで取得
     */
    public function getBirthdayFormattedAttribute(): string
    {
        return $this->date_of_birth ? $this->date_of_birth->format('Y-m-d') : '';
    }

    /**
     * 完全な住所を取得
     */
    public function getFullAddressAttribute(): string
    {
        if ($this->address) {
            return $this->address;
        }

        $parts = array_filter([
            $this->postal_code,
            $this->prefecture,
            $this->city,
            $this->street_address
        ]);

        return implode(' ', $parts);
    }
}
