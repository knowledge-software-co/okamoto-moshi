<?php
/**
 * @copyright   Knowledge Software Co.,Ltd. All Rights Reserved.
 * @since       2023/07/04
 * @author      Kazuki Kimura <kazu-kimura@knsw.co.jp>
 */

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => fake()->company(),
            'representative' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'comment' => fake()->realText(fake()->numberBetween(20, 50)),
            'advertising_payment_date' => fake()->dateTimeBetween($startDate = 'now', $endDate = '+4 week'),
        ];
    }
}
