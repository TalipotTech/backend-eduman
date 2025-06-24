<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Enums\UserRoles;
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
        $defaultUsers = array_merge(
            config('seeder.eduman_admins'),
        );

        collect($defaultUsers)
            ->map(fn($user) => User::factory()->create($user))
            ->map(function ($user) {
                $token = $user->createToken('testing');
                $this->command->info("User $user->email seeded with token $token->plainTextToken");
            });

        $adminCount = count(config('seeder.eduman_admins'));

        // Select all admin users
        $admins = User::where('id', '<=', $adminCount)->get();
        $admins->each(function ($admin) {
            $admin->role = UserRoles::ADMIN;
            $admin->save();
        });
    }
}