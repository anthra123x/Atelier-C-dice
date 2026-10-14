<?php

namespace Tests\Feature\Models;

use App\Models\Character;
use Tests\TestCase;

class CharacterTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new Character;
        $this->assertInstanceOf(Character::class, $model);
    }
}
