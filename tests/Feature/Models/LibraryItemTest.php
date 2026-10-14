<?php

namespace Tests\Feature\Models;

use App\Models\LibraryItem;
use Tests\TestCase;

class LibraryItemTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new LibraryItem;
        $this->assertInstanceOf(LibraryItem::class, $model);
    }
}
