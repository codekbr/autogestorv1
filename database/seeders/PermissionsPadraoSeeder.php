<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsPadraoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::firstOrCreate(['name' => 'aba-produtos']);
        Permission::firstOrCreate(['name' => 'aba-categorias']);
        Permission::firstOrCreate(['name' => 'aba-marcas']);
    }
}
