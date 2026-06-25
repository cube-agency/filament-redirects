<?php

namespace CubeAgency\FilamentRedirects\Database\Factories;

use CubeAgency\FilamentRedirects\Enums\RedirectStatus;
use CubeAgency\FilamentRedirects\Models\Redirect;
use Illuminate\Database\Eloquent\Factories\Factory;

class RedirectFactory extends Factory
{
    protected $model = Redirect::class;

    public function definition(): array
    {
        return [
            'from_url' => $this->faker->unique()->slug(),
            'to_url' => $this->faker->url(),
            'status' => $this->faker->randomElement([
                RedirectStatus::PERMANENT->value,
                RedirectStatus::TEMPORARY->value,
            ]),
        ];
    }

    public function permanent(): static
    {
        return $this->state(fn () => ['status' => RedirectStatus::PERMANENT->value]);
    }

    public function temporary(): static
    {
        return $this->state(fn () => ['status' => RedirectStatus::TEMPORARY->value]);
    }
}
