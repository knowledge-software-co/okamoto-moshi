<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Enums\Models\User\RoleType;
use App\Enums\Models\User\IsApprovedType;
use App\Observers\UserObserver;
use App\Traits\HasProfilePhoto;
use App\Traits\AuthorTrait;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
// use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * ログインユーザー用テーブル
 * 当システムにログインするユーザーの情報
 * プロフィールはProfileテーブルで管理
 */
#[ObservedBy([UserObserver::class])]
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    // use Cachable; // LaravelModelCaching作者がUserモデルをキャッシュすることはおすすめしないとのこと
    use AuthorTrait;
    use HasRoles;
    use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'uuid',
        'membership_number',
        'company_id',
        'email',
        'email_verified_at',
        'password',
        'role',
        // 'introducer_code',
        // 'google_id',
        'profile_photo_path',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'is_approved',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'stripe_id',
        'pm_type',
        'pm_last_four',
    ];

    /**
     * The accessors to append to the model's array form.
     */
    protected $appends = [
        /** @phpstan-ignore-next-line */
        'profile_photo_url',
        'name',
        'name_kana',
        'sex_name',
        'role_name',
        'role_label',
        'created_at_formated',
        'deleted_at_formated',
        'is_deleted',
        'is_system_admin',
        'is_admin',
        'is_developer',
        'is_member',
    ];

    /**
     * for eager loading
     */
    protected $with = [
        'profile',
        // 'employee',
        'userLocations',
        'company',
        'roles',
    ];

    protected static function booting()
    {
        static::creating(function ($user) {
            // UUIDをULIDに変更
            if (blank($user->uuid)) {
                $user->uuid = (string) Str::ulid();
            }
        });
    }

    /**
     * Implicit Bindingのカラム名を変更
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * ユーザーのフルネームを取得
     */
    public function getNameAttribute(): string
    {
        // @phpstan-ignore property.notFound
        return $this->profile ? $this->profile->name : '';
    }

    /**
     * ユーザーのフルネーム（カナ）を取得
     */
    public function getNameKanaAttribute(): string
    {
        // @phpstan-ignore property.notFound
        return $this->profile ? $this->profile->name_kana : '';
    }

    /**
     * ユーザーの性別を取得
     */
    public function getSexNameAttribute(): string|null
    {
        // @phpstan-ignore property.notFound
        return $this->profile ? $this->profile->sex_name : null;
    }

    /**
     * getRoleNameFormatAttribute
     */
    public function getRoleNameAttribute(): string
    {
        return RoleType::search($this->role)->value;
    }

    /**
     * getRoleNameFormatAttribute
     */
    public function getRoleLabelAttribute(): string
    {
        return RoleType::search($this->role)->label();
    }

    /**
     * getIsDeletedAttribute
     */
    public function getIsDeletedAttribute(): bool
    {
        return $this->trashed();
    }

    /**
     * getIsSystemAdminAttribute
     */
    public function getIsSystemAdminAttribute(): bool
    {
        return $this->hasRole('system admin');
    }

    /**
     * getIsAdminAttribute
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole('admin');
    }

    /**
     * getIsDeveloperAttribute
     */
    public function getIsDeveloperAttribute(): bool
    {
        return $this->hasRole('developer');
    }

    /**
     * getIsMemberAttribute
     */
    public function getIsMemberAttribute(): bool
    {
        return $this->hasRole('member');
    }

    /**
     * プロフィール情報
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }

    /**
     * このユーザーに紐づく住所
     */
    public function userLocations(): HasMany
    {
        return $this->hasMany(UserLocation::class);
    }

    /**
     * このユーザーに属する会社
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_approved' => IsApprovedType::class,
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
