<?php

namespace Database\Factories;

use App\Constants\Bits;
use App\Models\SymmetricKey;
use App\Util\KeyGenerator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SymmetricKeyComponent>
 */
class SymmetricKeyComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $component = KeyGenerator::make(Bits::Medium);

        return [
            'component' => $component->toBase64(),
            'kcv' => KeyGenerator::calculateKCV($component->getKey(), Bits::Medium),
            'symmetric_key_id' => SymmetricKey::factory(),

        ];
    }
}
