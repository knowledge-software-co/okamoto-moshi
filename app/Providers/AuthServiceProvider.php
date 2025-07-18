<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
// use Illuminate\Auth\Access\Response;
use App\Models\User;
// use App\Models\ItemUsageHistory;
use App\Enums\Models\User\RoleType;

class AuthServiceProvider extends ServiceProvider
{
    // /**
    //  * The model to policy mappings for the application.
    //  *
    //  * @var array<class-string, class-string>
    //  */
    // protected $policies = [
    //     // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    // ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('viewLogViewer', function (?User $user) {
            // return (Auth::check() && $user->role == (RoleType::SYSTEM_ADMIN)->value);
            return true;
        });

        // // dedoc/scramble 用
        // Gate::define('viewApiDocs', function (?User $user) {
        //     // return $user->is_admin;
        //     return true;
        // });

        Gate::define('all', function ($user) {
            return true;
        });

        Gate::define('system-admin', function ($user) {
            return ($user->role == (RoleType::SYSTEM_ADMIN)->value);
        });

        Gate::define('admin', function ($user) {
            return ($user->role == (RoleType::ADMIN)->value);
        });

        Gate::define('developer', function ($user) {
            return ($user->role == (RoleType::DEVELOPER)->value);
        });

        Gate::define('member', function ($user) {
            return ($user->role == (RoleType::MEMBER)->value);
        });

        // // アイテム「勤怠管理機能」を使用しているかどうか
        // Gate::define('item-using-time-record', function ($user) {
        //     if (!$user->is_member) {
        //         return false;
        //     }

        //     $result = ItemUsageHistory::where('user_id', $user->id)
        //         ->using()
        //         ->get()
        //         ->search(function ($itemUsageHistory) {
        //             return $itemUsageHistory->item->uuid == '01JH0002CMFCJKQK1Z1Z7BPTYQ';
        //         });

        //     if ($result !== false) {
        //         return Response::allow();
        //     }

        //     return Response::deny('アイテムを使用していません。');
        // });
    }
}
