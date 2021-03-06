<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $now = Carbon::now();
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'tell_number' => now(),
            'role' => $this->faker->randomElement([5, 10]),
            'user_id' => $this->faker->text(10),
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }
}
