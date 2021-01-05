<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use PhpParser\Node\Expr\FuncCall;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      $this->call([
          UsersQuestionsAnswersSeeder::class,
          FavoritesTableSeeder::class,
      ]);

    }
}
