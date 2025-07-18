<?php
namespace App\Http\Sorts\Admin\User;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;
use App\Models\Profile;

class NameSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $direction = $descending ? 'DESC' : 'ASC';

        return $query->with('profile')
        ->orderBy(
            Profile::select('last_name')
                ->whereColumn('profiles.id', 'users.profile_id'),
            $direction
        );
    }
}
