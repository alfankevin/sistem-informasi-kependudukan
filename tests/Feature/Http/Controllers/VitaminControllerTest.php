<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Vitamin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VitaminController
 */
class VitaminControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $vitamins = Vitamin::factory()->count(3)->create();

        $response = $this->get(route('vitamin.index'));

        $response->assertOk();
        $response->assertViewIs('vitamin.index');
        $response->assertViewHas('vitamins');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('vitamin.create'));

        $response->assertOk();
        $response->assertViewIs('vitamin.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VitaminController::class,
            'store',
            \App\Http\Requests\VitaminStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $nama_vitamin = $this->faker->word;
        $deskripsi = $this->faker->text;
        $usia_pemberian = $this->faker->word;
        $dosis = $this->faker->word;

        $response = $this->post(route('vitamin.store'), [
            'nama_vitamin' => $nama_vitamin,
            'deskripsi' => $deskripsi,
            'usia_pemberian' => $usia_pemberian,
            'dosis' => $dosis,
        ]);

        $vitamins = Vitamin::query()
            ->where('nama_vitamin', $nama_vitamin)
            ->where('deskripsi', $deskripsi)
            ->where('usia_pemberian', $usia_pemberian)
            ->where('dosis', $dosis)
            ->get();
        $this->assertCount(1, $vitamins);
        $vitamin = $vitamins->first();

        $response->assertRedirect(route('vitamin.index'));
        $response->assertSessionHas('vitamin.id', $vitamin->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $vitamin = Vitamin::factory()->create();

        $response = $this->get(route('vitamin.show', $vitamin));

        $response->assertOk();
        $response->assertViewIs('vitamin.show');
        $response->assertViewHas('vitamin');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $vitamin = Vitamin::factory()->create();

        $response = $this->get(route('vitamin.edit', $vitamin));

        $response->assertOk();
        $response->assertViewIs('vitamin.edit');
        $response->assertViewHas('vitamin');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VitaminController::class,
            'update',
            \App\Http\Requests\VitaminUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $vitamin = Vitamin::factory()->create();
        $nama_vitamin = $this->faker->word;
        $deskripsi = $this->faker->text;
        $usia_pemberian = $this->faker->word;
        $dosis = $this->faker->word;

        $response = $this->put(route('vitamin.update', $vitamin), [
            'nama_vitamin' => $nama_vitamin,
            'deskripsi' => $deskripsi,
            'usia_pemberian' => $usia_pemberian,
            'dosis' => $dosis,
        ]);

        $vitamin->refresh();

        $response->assertRedirect(route('vitamin.index'));
        $response->assertSessionHas('vitamin.id', $vitamin->id);

        $this->assertEquals($nama_vitamin, $vitamin->nama_vitamin);
        $this->assertEquals($deskripsi, $vitamin->deskripsi);
        $this->assertEquals($usia_pemberian, $vitamin->usia_pemberian);
        $this->assertEquals($dosis, $vitamin->dosis);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $vitamin = Vitamin::factory()->create();

        $response = $this->delete(route('vitamin.destroy', $vitamin));

        $response->assertRedirect(route('vitamin.index'));

        $this->assertModelMissing($vitamin);
    }
}
