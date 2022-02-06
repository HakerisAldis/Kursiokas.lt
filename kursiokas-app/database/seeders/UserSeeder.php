<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		User::factory()->count(1)->sequence(fn ($sequence) => ['email' => 'admin@admin', 'type' => '0'])->create();
		
		User::factory()->count(10)->sequence(fn ($sequence) => ['email' => 'lecturer' . $sequence->index . '@test.com', 'type' => '1'])->create();
		
        User::factory()->count(200)->sequence(fn ($sequence) => ['email' => 'user' . $sequence->index . '@test.com'])->create();
    }
}
