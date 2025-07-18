<?php

namespace Database\Factories;

use App\Enums\Models\User\SexType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'last_name' => fake()->lastName(),
            'first_name' => fake()->firstName(),
            'last_name_kana' => fake()->lastKanaName(),
            'first_name_kana' => fake()->firstKanaName(),
            'date_of_birth' => fake()->dateTimeBetween('-60 years', '-18 years'),
            'sex_code' => fake()->randomElement([SexType::MALE->value, SexType::FEMALE->value]),
            'email' => fake()->email(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'postal_code' => fake()->postcode(),
            'prefecture' => fake()->prefecture(),
            'city' => fake()->city(),
            'street_address' => fake()->streetAddress(),
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }

    /**
     * 特定の名前情報
     */
    public function withName($lastName, $firstName, $lastNameKana = null, $firstNameKana = null): self
    {
        return $this->state(function (array $attributes) use ($lastName, $firstName, $lastNameKana, $firstNameKana) {
            return [
                'last_name' => $lastName,
                'first_name' => $firstName,
                'last_name_kana' => $lastNameKana ?? fake()->lastKanaName(),
                'first_name_kana' => $firstNameKana ?? fake()->firstKanaName(),
            ];
        });
    }

    /**
     * 男性プロフィール
     */
    public function male(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'sex_code' => SexType::Male->value,
            ];
        });
    }

    /**
     * 女性プロフィール
     */
    public function female(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'sex_code' => SexType::FEMALE->value,
            ];
        });
    }
}
