<?php

namespace Database\Seeders;

use App\Models\Historicoportas;
use App\Models\Historico;
use App\Models\User;
use App\Models\Host;
use App\Models\Porta;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Host::factory(3)->create();
        // User::factory(3)->create();
        // Porta::factory(3)->create();
        Historico::factory(3)->create();
        Historicoportas::factory(3)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Host::factory()->create([
        //     'nome' => 'Test Host',
        //     'ip' => 'www.google.com',
        //     'id_user' => '1',
        // ]);
    }
}
