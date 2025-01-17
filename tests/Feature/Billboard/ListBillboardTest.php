<?php

namespace Tests\Feature\Billboard;

use App\Filament\Resources\BillboardResource;
use Tests\TestCase;

class ListBillboardTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_can_render_page(): void
    {
        $this->get(BillboardResource::getUrl('index'))->assertSuccessful();
    }
}
