<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CustomerSeeder extends Seeder
{
    const CUSTOMER_EMAIL = 'customer@customer.com';

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        if (! User::where('email', self::CUSTOMER_EMAIL)->exists()) {
            (User::factory()->withEmail(self::CUSTOMER_EMAIL)->create())
                ->syncRoles(Roles::CUSTOMER);
        }

        User::factory(10)->create();
    }
}
