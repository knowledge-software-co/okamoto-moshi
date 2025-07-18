<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;

/**
 * Class AuthorObserver
 * @package App\Observers
 *
 * 参考: Laravelのeloquentのeventでcreated_byとかupdated_byとか更新するobserverとtrait
 *       https://qiita.com/maimai-swap/items/6597c04721adbc48fec2
 */
class AuthorObserver
{
    public function created(Model $model): void
    {
        if (property_exists($model, 'created_by') && auth()->check()) {
            $model->created_by = auth()->user()->id ?? null;
        }
    }

    public function updating(Model $model): void
    {
        if (property_exists($model, 'updated_by') && auth()->check()) {
            $model->updated_by = auth()->user()->id ?? null;
        }
    }

    public function saving(Model $model): void
    {
        if (property_exists($model, 'updated_by') && auth()->check()) {
            $model->updated_by = auth()->user()->id ?? null;
        }
    }

    public function deleting(Model $model): void
    {
        if (property_exists($model, 'deleted_by') && auth()->check()) {
            $model->deleted_by = auth()->user()->id ?? null;
        }
    }

    public function restoring(Model $model): void
    {
        if (property_exists($model, 'restored_by') && auth()->check()) {
            $model->restored_by = auth()->user()->id ?? null;
        }
    }
}
