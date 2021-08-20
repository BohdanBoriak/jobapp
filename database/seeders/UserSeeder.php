<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\User;
use App\Models\Vacancy;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // to create simple admin, worker and employer

        User::factory()
            ->state([
                'email' => 'admin@localhost',
                'password' => '123456',
                'role'=> 'admin',
            ])
            ->create();

        User::factory()
            ->state([
                'email' => 'employer@localhost',
                'password' => '123456',
                'role'=> 'employer',
            ])
            ->create();

        User::factory()
            ->state([
                'email' => 'worker@localhost',
                'password' => '123456',
                'role'=> 'worker',
            ])
            ->create();

        User::factory()
            ->state([
                'role' => 'worker',
                'password' => '123456',
            ])
            ->count(50)
            ->create();

        // to create users+companies+vacancies related to users

        User::factory()
            ->state([
                'role' => 'employer',
                'password' => '123456',
            ])
            ->count(50) // insert how many users you want to be created
            ->has(Company::factory()
                ->count(1) // insert how many companies you want to be created by a single user total_amount = user(count)*company(count)
                ->state(function (array $attributes, User $user) {
                    return ['created_by' => $user->id];
                })
                ->has(Vacancy::factory()
                    ->count(1) // insert how many vacancies you want to be created by a single user total_amount = user(count)*company(count)*vacancy(count)
                    ->state(function (array $attributes, Company $company) {
                        return [
                            'company_id' => $company->id,
                            'created_by_user' => $company->created_by
                        ];
                    })
                )
            )
            ->create();
    }
}
