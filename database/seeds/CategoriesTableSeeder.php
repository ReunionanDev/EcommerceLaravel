<?php

use App\Category;
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
        Category::create([
            'name' => 'Ordinateur',
            'slug' => 'ordinateur'
        ]);

        Category::create([
            'name' => 'Téléphones',
            'slug' => 'téléphones'
        ]);

        Category::create([
            'name' => 'Jeux',
            'slug' => 'jeux'
        ]);

        Category::create([
            'name' => 'Périphériques',
            'slug' => 'périphériques'
        ]);

        Category::create([
            'name' => 'Gaming',
            'slug' => 'gaming'
        ]);
    }
}
