<?php

use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run()
    {
        factory(\App\Gallery::class, 25)->create();
    }
}