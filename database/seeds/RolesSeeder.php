<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['titleRol' => 'Admin'],
            ['titleRol' => 'Client']
        ];
        DB::table('roles')->insert($data);
    }
}
