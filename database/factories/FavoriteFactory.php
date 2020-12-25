<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Reply;
use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\Factory;

class FavoriteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Favorite::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->create(),
            'favorited_id' => Reply::factory()->create(),
            'favorited_type' => 'App\Models\Reply'
        ];
    }
}
