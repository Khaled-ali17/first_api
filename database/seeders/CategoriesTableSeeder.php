<?php

namespace Database\Seeders;

use App\Models\Api_Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $categoriesRecordes = [
            [
                "id" => 1,
                "name_ar" => "ملابس ",
                "name_en" => "clothes",
               // "status_active" =>1,
            ],
            [
                "id" => 2,
                "name_ar" => " أحذية",
                "name_en" => "shoes",
              //  "status_active" =>1,
            ],
        ];

        Category::insert($categoriesRecordes);
    }
}
