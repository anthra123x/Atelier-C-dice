<?php

namespace Tests\Feature\Models;

use App\Models\AudioTrack;
use Tests\TestCase;

class AudioTrackTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_model_can_be_instantiated(): void
    {
        $model = new AudioTrack;
        $this->assertInstanceOf(AudioTrack::class, $model);
    }
}
