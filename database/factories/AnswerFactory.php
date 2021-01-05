<?php

namespace Database\Factories;

use App\Models\Answer;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnswerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Answer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
           'body' => $this->faker->paragraphs(rand(3,7),true),
           'user_id'=> \App\Models\User::pluck('id')->random(),
           'votes_cout' => rand(1, 10),
        ];
    }
}
