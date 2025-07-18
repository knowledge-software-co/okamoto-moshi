<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/01/24
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Factories;

use App\Models\UserLocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class UserLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'phone' => fake()->phoneNumber(),
            'postal_code' => fake()->postcode(),
            // 'prefecture' => fake()->prefecture(),
            'prefecture_id' => fake()->numberBetween(1, 47),
            'address1' => fake()->city() . fake()->streetName(),
            'address2' => fake()->streetAddress(),
        ];
    }

    /**
     * Indicate that the user location should have a user_id.
     */
    public function forUser(User $user): self
    {
        return $this->state(function (array $attributes) use ($user) {
            return [
                'user_id' => $user->id,
            ];
        });
    }
}
