<?php

namespace App\Traits;

use App\Observers\AuthorObserver;
use Illuminate\Support\Carbon;

/**
 * Trait AuthorTrait
 * @package App\Traits
 *
 * 参考: Laravelのeloquentのeventでcreated_byとかupdated_byとか更新するobserverとtrait
 *       https://qiita.com/maimai-swap/items/6597c04721adbc48fec2
 */
trait AuthorTrait
{
    /**
     * Boot the AuthorObservable trait for a model.
     */
    public static function bootAuthorObservable(): void
    {
        self::observe(AuthorObserver::class);
    }

    /**
     * getModifiedAtAttribute
     */
    public function getModifiedAtAttribute(): Carbon|\Carbon\Carbon|null
    {
        /** @phpstan-ignore-next-line */
        return ($this->updated_at) ? $this->updated_at : $this->created_at;
    }

    /**
     * getCreatedAtFormatedFormatAttribute
     */
    public function getCreatedAtFormatedAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->created_at?->format('Y-m-d H:i');
    }

    /**
     * getCreatedAtFormatedOnlyDateAttribute
     */
    public function getCreatedAtFormatedOnlyDateAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->created_at?->format('Y-m-d');
    }

    /**
     *  getUpdatedAtFormatedAttribute
     */
    public function getUpdatedAtFormatedAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->updated_at?->format('Y-m-d H:i');
    }

    /**
     * getUpdatedAtFormatedOnlyDateAttribute
     */
    public function getUpdatedAtFormatedOnlyDateAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->updated_at?->format('Y-m-d');
    }

    /**
     * getDeletedAtFormatedFormatAttribute
     */
    public function getDeletedAtFormatedAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->deleted_at?->format('Y-m-d H:i');
    }

    /**
     * getDeletedAtFormatedOnlyDateAttribute
     */
    public function getDeletedAtFormatedOnlyDateAttribute(): string|null
    {
        /** @phpstan-ignore-next-line */
        return $this->deleted_at?->format('Y-m-d');
    }
}
