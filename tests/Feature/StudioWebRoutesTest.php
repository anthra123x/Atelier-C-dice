<?php

namespace Tests\Feature;

use Tests\TestCase;

class StudioWebRoutesTest extends TestCase
{
    public function test_canvas_page_loads_successfully(): void
    {
        $response = $this->get(route('studio.canvas'));
        $response->assertOk()
            ->assertSee('Estudio')
            ->assertSee('Cóice')
            ->assertSee('Lienzo Creativo');
    }

    public function test_characters_page_loads_successfully(): void
    {
        $response = $this->get(route('studio.characters'));
        $response->assertOk()
            ->assertSee('Fichas de Personajes')
            ->assertSee('Kaelen Vance');
    }

    public function test_maps_page_loads_successfully(): void
    {
        $response = $this->get(route('studio.maps'));
        $response->assertOk()
            ->assertSee('Cartografía')
            ->assertSee('Almacén 17');
    }

    public function test_library_page_loads_successfully(): void
    {
        $response = $this->get(route('studio.library'));
        $response->assertOk()
            ->assertSee('Biblioteca')
            ->assertSee('Compendio de Lore');
    }
}
