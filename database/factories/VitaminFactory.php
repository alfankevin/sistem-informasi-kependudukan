<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Vitamin;

class VitaminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vitamin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_vitamin' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'deskripsi' => $this->faker->text,
            'usia_pemberian' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'dosis' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
