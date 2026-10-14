<?php

namespace Tests\Feature\Models;

use App\Models\Universe;
use Tests\TestCase;

class UniverseTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new Universe;
        $this->assertInstanceOf(Universe::class, $model);
    }
}
