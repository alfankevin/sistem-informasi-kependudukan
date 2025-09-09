<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Posyandu;
use App\Models\PosyanduVaksin;
use App\Models\Vaksin;

class PosyanduVaksinFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PosyanduVaksin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'posyandu_id' => Posyandu::factory(),
            'vaksin_id' => Vaksin::factory(),
            'dosis_ke' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
