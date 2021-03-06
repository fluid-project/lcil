<?php

namespace Database\Factories;

use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $regions = get_regions(['CA'], config('app.locale'));

        return [
            'name' => $this->faker->company(),
            'locality' => $this->faker->city(),
            'region' => array_keys($regions)[$this->faker->numberBetween(1, 13)]
        ];
    }
}
