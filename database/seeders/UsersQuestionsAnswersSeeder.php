<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersQuestionsAnswersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('answers')->delete();
        DB::table('questions')->delete();
        DB::table('users')->delete();
        \App\Models\User::factory(3)->create()
            ->each(function ($u) {
                $u->questions()
                    ->saveMany(\App\Models\Question::factory(rand(1, 5))->make())->each(function ($t) {
                    $t->answers()
                        ->saveMany(\App\Models\Answer::factory(rand(1, 5))->make());
                });
            });

    }
}
