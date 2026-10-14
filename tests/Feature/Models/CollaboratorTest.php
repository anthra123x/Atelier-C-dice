<?php

namespace Tests\Feature\Models;

use App\Models\Collaborator;
use Tests\TestCase;

class CollaboratorTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new Collaborator;
        $this->assertInstanceOf(Collaborator::class, $model);
    }
}
