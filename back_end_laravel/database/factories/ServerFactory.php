<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Server>
 */
class ServerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

     protected $model = Server::class;
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'password' => '',
            'creator_id' => '1',
            'description' => fake()->text(30)
        ];
    }
}
