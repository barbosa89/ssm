<?php

namespace Database\Factories;

use App\Constants\Bits;
use App\Constants\SymmetricKeyTypes;
use App\Util\KeyGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SymmetricKey>
 */
class SymmetricKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'description' => fake()->sentence(),
            'type' => SymmetricKeyTypes::TripleDES->name,
            'bits' => Bits::Medium->value,
            'key' => KeyGenerator::make(Bits::Medium)->toBase64(),
        ];
    }
}
