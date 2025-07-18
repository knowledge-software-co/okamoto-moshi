<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Company;
use App\Models\Profile;
use App\Models\UserLocation;
// use App\Models\UserReferralCode;
use App\Enums\Models\User\SexType;
use App\Enums\Models\User\RoleType;
use Faker\Factory as FakerFactory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * @param array|\Spatie\Permission\Contracts\Role|string  ...$roles
     * @return UserFactory
     * NOTE: https://abartelt.medium.com/laravel-8-user-factory-with-role-states-1d93a7521800
     */
    private function assignRole(...$roles): UserFactory
    {
        return $this->afterCreating(fn(User $user) => $user->syncRoles($roles));
    }

    /**
     * ユニークなメールアドレスを生成する
     * NOTE: https://zenn.dev/asuene/articles/5e21fce10b0734
     */
    private function generateEmail(): string
    {
        $fakerEn = FakerFactory::create('en_US');
        $email = $fakerEn->firstName();
        $email .= $fakerEn->lastName();
        $email .= '+' . (string)fake()->numberBetween(1, 1000);
        $email .= '@';
        $email .= fake()->safeEmailDomain();
        return $email;
    }

    /**
     * Creating a user with a Stripe customer ID.
     */
    public function createAsStripeCustomer(): UserFactory
    {
        // return $this->afterCreating(
        //     fn (User $user) => $user->createAsStripeCustomer(['preferred_locales' => ['ja']])
        // );
        return $this;
    }

    // /**
    //  * ユーザーにプロフィールを作成
    //  */
    // public function withProfile(array $attributes = []): UserFactory
    // {
    //     return $this->afterCreating(function (User $user) use ($attributes) {
    //         $profile = Profile::factory()
    //             ->forUser($user->id)
    //             ->create($attributes);

    //         return $profile;
    //     });
    // }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::ulid(),
            // 'last_name' => fake()->lastName(),
            // 'first_name' => fake()->firstName(),
            // 'last_name_kana' => fake()->lastKanaName(),
            // 'first_name_kana' => fake()->firstKanaName(),
            // 'email' => fake()->unique()->safeEmail(),
            'email' => $this->generateEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // 'phone' => fake()->phoneNumber(),
            // 'sex_code' => fake()->randomElement([SexType::MALE->value, SexType::FEMALE->value]), // 1 or 2
            // 'age' => fake()->numberBetween(20, 100),
            // 'date_of_birth' => fake()->date(),
            // 'is_approved' => IsApproved::Approved->value, // 承認
            // 'is_agreed' => 1, // 同意
            'created_by' => 1,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * システム管理者
     */
    public function systemAdmin(): self
    {
        return $this->state(fn ()  => [
            // 'membership_number' => \Sequence::getNewUserNo('system admin'),
            'role' => RoleType::SYSTEM_ADMIN->value,
        ])
        // ->withProfile()
        ->for(Profile::factory())
        ->assignRole('system admin');
    }

    /**
     * 運営者
     */
    public function admin(): self
    {
        return $this
            // ->for(Company::factory(1)->create()) // becose belongsTo
            // ->has(UserReferralCode::factory(1))
            ->state(fn ()  => [
                // 'membership_number' => \Sequence::getNewUserNo('admin'),
                'company_id' => 1, // '株式会社ナレッジソフトウェア'
                'role' => RoleType::ADMIN->value,
            ])
            // ->withProfile()
            ->for(Profile::factory())
            ->assignRole('admin')
        ;
    }

    /**
     * 開発者
     */
    public function developer(): self
    {
        return $this
            // ->has(UserReferralCode::factory(1))
            // ->has(
            //     Item::factory(1)
            //         ->state(
            //             fn (array $attributed, User $user)  => [
            //                 'developer_id' => $user->id,
            //             ]
            //         )
            //         ->has(
            //             DeveloperRewardHistory::factory(3)
            //                 ->state(fn (array $attributes, Item $item) => [
            //                     'developer_id' => $item->developer_id,
            //                     'item_id' => $item->id,
            //                 ])
            //         )
            // )
            ->state(fn ()  => [
                // 'membership_number' => \Sequence::getNewUserNo('developer'),
                'company_id' => 1, // '株式会社ナレッジソフトウェア'
                'role' => RoleType::DEVELOPER->value,
            ])
            // ->withProfile()
            ->for(Profile::factory())
            ->assignRole('developer')
        ;
    }

    /**
     * 一般ユーザー
     * @param int $companyId 会社ID
     */
    public function member(int $companyId = null): self
    {
        $member = $this
            // ->for(Company::factory(1)->create()) // becose belongsTo
            ->has(UserLocation::factory(1))
            // ->has(UserReferralCode::factory(1))
            // ->state(
            //     fn (array $attributed)  => [
            //         'introducer_code' => UserReferralCode::get()->random()->referral_code,
            //         'company_id' => Company::get()->random()->id,
            //     ]
            // )
            ->state(fn ()  => [
                // 'membership_number' => \Sequence::getNewUserNo('member'),
                'company_id' => $companyId ?? 1, // '株式会社ナレッジソフトウェア'
                'role' => RoleType::MEMBER->value,
            ])
        ;

        // if ($hasItemUsageHistory) {
        //     $member = $member->has(ItemUsageHistory::factory(4));
        // }

        $member = $member
            // ->has(ItemUsageHistory::factory(1)->mustItem())
            // ->withProfile()
            ->for(Profile::factory())
            ->assignRole('member')
            // ->assignPlanBaseOnThePoints()
            ->createAsStripeCustomer()
        ;

        return $member;
    }
}
