<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Vaksin;

class VaksinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vaksin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama_vaksin' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'deskripsi' => $this->faker->text,
            'usia_pemberian' => $this->faker->regexify('[A-Za-z0-9]{50}'),
            'dosis_total' => $this->faker->numberBetween(-10000, 10000),
            'interval' => $this->faker->regexify('[A-Za-z0-9]{50}'),
        ];
    }
}
