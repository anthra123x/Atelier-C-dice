<?php

namespace Tests\Feature\Models;

use App\Models\CanvasNode;
use Tests\TestCase;

class CanvasNodeTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new CanvasNode;
        $this->assertInstanceOf(CanvasNode::class, $model);
    }
}
