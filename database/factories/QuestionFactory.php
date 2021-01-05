<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Question::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            // 'user_id' => User::factory(),
            'title' => $this->faker->sentence(rand(5,10)),
            'body' => $this->faker->paragraphs(rand(3,7),true),
            'views' => rand(1, 10),
            // 'answer_count' => rand(1, 10),
            'votes_count' => rand(1, 10),
        ];
    }
}
