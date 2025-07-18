<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Http\UseCase\Admin\User\{
    IndexAction,
    ShowAction,
    CreateAction,
    StoreAction,
};
use App\Http\Requests\Admin\User\Owner\UserStoreRequest;
use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * index
     *
     * @return \Inertia\Response
     */
    public function index(Request $request, IndexAction $action)
    {
        return $action($request);
    }

    /**
     * show
     *
     * @return \Inertia\Response
     */
    public function show(Request $request, User $user, ShowAction $action)
    {
        return $action($request, $user);
    }

    // /**
    //  * create
    //  */
    // public function create(Request $request, CreateAction $action)
    // {
    //     return $action($request);
    // }

    // /**
    //  * store
    //  */
    // public function store(UserStoreRequest $request, StoreAction $action)
    // {
    //     // NOTE: Userモデル内には銀行情報が含まれていないため、$request->validated()で銀行情報を取得する
    //     // $action($request->makeUser(), $request->validated());
    //     return $action($request);
    // }
}
