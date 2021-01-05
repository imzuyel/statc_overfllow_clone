<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('favorites')->delete();
        $users = User::pluck('id')->all();
        $mumbersOfUser = count($users);
        foreach (Question::all() as $question) {
            for ($i = 0; $i < rand(0, $mumbersOfUser); $i++) {
                $user = $users[$i];
                $question->favorites()->attach($user);
            }
        }
    }
}
