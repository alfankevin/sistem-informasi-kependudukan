<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PosyanduVitamin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PosyanduVitaminController
 */
class PosyanduVitaminControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $posyanduVitamins = PosyanduVitamin::factory()->count(3)->create();

        $response = $this->get(route('posyandu-vitamin.index'));

        $response->assertOk();
        $response->assertViewIs('posyanduVitamin.index');
        $response->assertViewHas('posyanduVitamins');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('posyandu-vitamin.create'));

        $response->assertOk();
        $response->assertViewIs('posyanduVitamin.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosyanduVitaminController::class,
            'store',
            \App\Http\Requests\PosyanduVitaminStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $response = $this->post(route('posyandu-vitamin.store'));

        $response->assertRedirect(route('posyanduVitamin.index'));
        $response->assertSessionHas('posyanduVitamin.id', $posyanduVitamin->id);

        $this->assertDatabaseHas(posyanduVitamins, [ /* ... */ ]);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $posyanduVitamin = PosyanduVitamin::factory()->create();

        $response = $this->get(route('posyandu-vitamin.show', $posyanduVitamin));

        $response->assertOk();
        $response->assertViewIs('posyanduVitamin.show');
        $response->assertViewHas('posyanduVitamin');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $posyanduVitamin = PosyanduVitamin::factory()->create();

        $response = $this->get(route('posyandu-vitamin.edit', $posyanduVitamin));

        $response->assertOk();
        $response->assertViewIs('posyanduVitamin.edit');
        $response->assertViewHas('posyanduVitamin');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PosyanduVitaminController::class,
            'update',
            \App\Http\Requests\PosyanduVitaminUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $posyanduVitamin = PosyanduVitamin::factory()->create();

        $response = $this->put(route('posyandu-vitamin.update', $posyanduVitamin));

        $posyanduVitamin->refresh();

        $response->assertRedirect(route('posyanduVitamin.index'));
        $response->assertSessionHas('posyanduVitamin.id', $posyanduVitamin->id);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $posyanduVitamin = PosyanduVitamin::factory()->create();

        $response = $this->delete(route('posyandu-vitamin.destroy', $posyanduVitamin));

        $response->assertRedirect(route('posyanduVitamin.index'));

        $this->assertModelMissing($posyanduVitamin);
    }
}
