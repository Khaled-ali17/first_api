<?php

namespace Database\Seeders;

use App\Models\Api_Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $adminRecordes = [
            [
                "id" => 2,
                "name" => "khaled dev",
                "email" => "dev@gmail.com",
                "password" => bcrypt("123456"),
            ],
        ];

        Admin::insert($adminRecordes);
    }
}
