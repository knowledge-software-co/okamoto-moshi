<?php

namespace App\Http\UseCase\Admin\User;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Models\User;
use App\Enums\Models\User\RoleType;
use App\Http\Sorts\Admin\User\NameSort;
use App\Traits\InertiaTable\InertiaTable;
use Inertia\Inertia;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

class IndexAction
{
    public function __invoke(Request $request)
    {
        /**
         * laravel datatabeles
         */
        $globalSearch = AllowedFilter::callback('global', function ($query, $value) {
            $query->where(function ($query) use ($value) {
                Collection::wrap($value)->each(function ($value) use ($query) {
                    $query
                        ->orWhereHas('profile', function ($q) use ($value) {
                            $q->where('last_name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('profile', function ($q) use ($value) {
                            $q->where('first_name', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('profile', function ($q) use ($value) {
                            $q->where('last_name_kana', 'LIKE', "%{$value}%");
                        })
                        ->orWhereHas('profile', function ($q) use ($value) {
                            $q->where('first_name_kana', 'LIKE', "%{$value}%");
                        })
                        ->orWhere('email', 'LIKE', "%{$value}%");
                });
            });
        });
        $users = QueryBuilder::for(
            User::with([
                'roles',
                // 'servicePlan',
            ])->where('role', '!=', RoleType::SYSTEM_ADMIN)
        )
            // ->withTrashed()
            ->defaultSort('-id')
            ->allowedSorts([
                AllowedSort::custom('name', new NameSort(), 'name'),
                'profile.sex_label',
                'role_label',
                'is_approved_label',
            ])
            ->allowedFilters(['profile.last_name', 'profile.first_name', 'email', 'profile.sex_label', 'role', 'is_approved', $globalSearch])
            ->paginate($request->perPage ?? 10)
            ->withQueryString()
        ;

        return Inertia::render(
            'admin/users/Index',
            compact('users')
        )->table(function (InertiaTable $table) {
            $table
                // ->column('id', 'ID', searchable: true, sortable: true)
                // ->column('membership_number', '会員番号', searchable: true, sortable: true)
                ->column('name', '名前', searchable: true, sortable: true)
                ->column('created_at_formated', '作成日', searchable: true, sortable: true)
                // ->column('email', 'メールアドレス', searchable: true, sortable: true, hidden: true)
                // ->column('service_plan', '利用プラン', searchable: true, sortable: true)
                ->column('sex_name', '性別', searchable: false, sortable: false)
                ->column('role_label', '権限', searchable: false, sortable: false)
                // ->column('is_approved_label', '承認', searchable: false, sortable: false)
                // ->column('deleted_at_formated', '削除日', searchable: false, sortable: true)
                // ->column(label: '参照', canBeHidden: false)
                // ->column(label: '編集', canBeHidden: false)
                // ->column(label: '削除', canBeHidden: false)
                ->column(label: '操作', canBeHidden: false)
                ->withGlobalSearch('「性・名」「セイ・メイ」「メールアドレス」からあいまい検索')
                ->selectFilter(key: 'role', label: '会員種別', options: [
                    RoleType::MEMBER->value => RoleType::MEMBER->label(),
                    RoleType::DEVELOPER->value => RoleType::DEVELOPER->label(),
                    RoleType::ADMIN->value => RoleType::ADMIN->label(),
                    // RoleType::LabMaster->value => RoleType::LabMaster->label(),
                    // RoleType::Staff->value => RoleType::Staff->label(),
                ])
            ;
        });
    }
}
