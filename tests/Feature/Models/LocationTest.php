<?php

namespace Tests\Feature\Models;

use App\Models\Location;
use Tests\TestCase;

class LocationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new Location;
        $this->assertInstanceOf(Location::class, $model);
    }
}
