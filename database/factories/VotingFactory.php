<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Voting>
 */
class VotingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'slug_id' => fake()->uuid(),
            'announcement_id' => mt_rand(1,10),
            'category_id' => mt_rand(1,2),
            'user_id' => mt_rand(1,10),
            'judul_voting' => fake()->title(),
            'nama_admin' => fake()->name(),
            'pesan_voting' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, delectus animi quod, atque dicta, neque nisi enim consequuntur distinctio nobis hic illum aliquid rem iste!',
            'durasi_voting' => mt_rand(3,10)
        ];
    }
}
