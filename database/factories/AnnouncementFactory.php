<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Announcement>
 */
class AnnouncementFactory extends Factory
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
            'category_id' => mt_rand(1,2),
            'user_id' => mt_rand(1,10),
            'judul' => fake()->title(),
            'nama_admin' => fake()->name(),
            'pesan' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum, delectus animi quod, atque dicta, neque nisi enim consequuntur distinctio nobis hic illum aliquid rem iste!',
            'durasi' => mt_rand(3,10)
        ];
    }
}
