<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PosyanduVaksin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PosyanduVaksinController
 */
class PosyanduVaksinControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $posyanduVaksins = PosyanduVaksin::factory()->count(3)->create();

        $response = $this->get(route('posyandu-vaksin.index'));

        $response->assertOk();
        $response->assertViewIs('posyanduVaksin.index');
        $response->assertViewHas('posyanduVaksins');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('posyandu-vaksin.create'));

        $response->assertOk();
        $response->assertViewIs('posyanduVaksin.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosyanduVaksinController::class,
            'store',
            \App\Http\Requests\PosyanduVaksinStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $response = $this->post(route('posyandu-vaksin.store'));

        $response->assertRedirect(route('posyanduVaksin.index'));
        $response->assertSessionHas('posyanduVaksin.id', $posyanduVaksin->id);

        $this->assertDatabaseHas(posyanduVaksins, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $posyanduVaksin = PosyanduVaksin::factory()->create();

        $response = $this->get(route('posyandu-vaksin.show', $posyanduVaksin));

        $response->assertOk();
        $response->assertViewIs('posyanduVaksin.show');
        $response->assertViewHas('posyanduVaksin');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $posyanduVaksin = PosyanduVaksin::factory()->create();

        $response = $this->get(route('posyandu-vaksin.edit', $posyanduVaksin));

        $response->assertOk();
        $response->assertViewIs('posyanduVaksin.edit');
        $response->assertViewHas('posyanduVaksin');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosyanduVaksinController::class,
            'update',
            \App\Http\Requests\PosyanduVaksinUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $posyanduVaksin = PosyanduVaksin::factory()->create();

        $response = $this->put(route('posyandu-vaksin.update', $posyanduVaksin));

        $posyanduVaksin->refresh();

        $response->assertRedirect(route('posyanduVaksin.index'));
        $response->assertSessionHas('posyanduVaksin.id', $posyanduVaksin->id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $posyanduVaksin = PosyanduVaksin::factory()->create();

        $response = $this->delete(route('posyandu-vaksin.destroy', $posyanduVaksin));

        $response->assertRedirect(route('posyanduVaksin.index'));

        $this->assertModelMissing($posyanduVaksin);
    }
}
