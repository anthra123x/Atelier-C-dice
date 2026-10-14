<?php

namespace Tests\Feature\Models;

use App\Models\CanvasConnection;
use Tests\TestCase;

class CanvasConnectionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new CanvasConnection;
        $this->assertInstanceOf(CanvasConnection::class, $model);
    }
}
