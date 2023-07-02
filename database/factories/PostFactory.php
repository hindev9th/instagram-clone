<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Post;
use Faker\Generator as Faker;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

$factory->define(Post::class, function (Faker $faker) {
    $images = Storage::allFiles();
    $key = array_rand($images);
    $image = preg_replace("/public\//","",$images[$key]);
    return [
        "user_id" => User::all()->random()->id,
        "caption" => $faker->text,
        "image" => $image,
    ];
});
