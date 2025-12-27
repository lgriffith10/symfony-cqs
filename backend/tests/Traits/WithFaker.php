<?php

namespace App\Tests\Traits;

use Faker\Factory;
use Faker\Generator;

trait WithFaker
{
    private static ?Generator $faker = null;

    protected static function faker(): Generator
    {
        if (null === self::$faker) {
            self::$faker = Factory::create('fr_FR');
        }

        return self::$faker;
    }
}
