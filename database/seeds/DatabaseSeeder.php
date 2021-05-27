<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(UsersTableSeeder::class);
         $this->call(OperAdminsTable::class);
         $this->call(OperMenuTable::class);
         $this->call(InstitucionesSeeder::class);
         $this->call(RegistradoresSeeder::class);
         $this->call(TramitesRegistradoresSeeder::class);

    }
}
