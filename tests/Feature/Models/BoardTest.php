<?php

namespace Tests\Feature\Models;

use App\Models\Board;
use Tests\TestCase;

class BoardTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new Board;
        $this->assertInstanceOf(Board::class, $model);
    }
}
