<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Posyandu;
use App\Models\PosyanduVitamin;
use App\Models\Vitamin;

class PosyanduVitaminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PosyanduVitamin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'posyandu_id' => Posyandu::factory(),
            'vitamin_id' => Vitamin::factory(),
            'catatan' => $this->faker->word,
        ];
    }
}
