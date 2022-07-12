<?php

declare(strict_types=1);


namespace Database\Factories;

use App\Models\Link;
use Illuminate\Database\Eloquent\Factories\Factory;

class LinkFactory extends Factory
{


    public function definition()
    {
        return [
            'link' => $this->faker->url(),
            'hash' => '0000',
            'usageLimit' => random_int(Link::MIN_USAGE, Link::MAX_USAGE),
            'ttl' => random_int(Link::MIN_USAGE, Link::MAX_USAGE),
        ];
    }
}
