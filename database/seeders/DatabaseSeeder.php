<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
      * Seed the application's database.
      */
    public function run(): void
    {
        // Seed default financial configuration values
        Setting::setValue('bolsa_auxilio', 1000.00);
        Setting::setValue('alimentacao_dia', 20.00);
        Setting::setValue('transporte_dia', 15.00);
        Setting::setValue('dinheiro_mae', 100.00);

        // Also add user if needed
        if (! User::where('email', 'test@example.com')->exists()) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }
    }
}
