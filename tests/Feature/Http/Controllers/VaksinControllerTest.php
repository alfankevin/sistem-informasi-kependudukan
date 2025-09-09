<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Vaksin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\VaksinController
 */
class VaksinControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function index_displays_view()
    {
        $vaksins = Vaksin::factory()->count(3)->create();

        $response = $this->get(route('vaksin.index'));

        $response->assertOk();
        $response->assertViewIs('vaksin.index');
        $response->assertViewHas('vaksins');
    }


    /**
     * @test
     */
    public function create_displays_view()
    {
        $response = $this->get(route('vaksin.create'));

        $response->assertOk();
        $response->assertViewIs('vaksin.create');
    }


    /**
     * @test
     */
    public function store_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VaksinController::class,
            'store',
            \App\Http\Requests\VaksinStoreRequest::class
        );
    }

    /**
     * @test
     */
    public function store_saves_and_redirects()
    {
        $nama_vaksin = $this->faker->word;
        $deskripsi = $this->faker->text;
        $usia_pemberian = $this->faker->word;
        $dosis_total = $this->faker->numberBetween(-10000, 10000);
        $interval = $this->faker->word;

        $response = $this->post(route('vaksin.store'), [
            'nama_vaksin' => $nama_vaksin,
            'deskripsi' => $deskripsi,
            'usia_pemberian' => $usia_pemberian,
            'dosis_total' => $dosis_total,
            'interval' => $interval,
        ]);

        $vaksins = Vaksin::query()
            ->where('nama_vaksin', $nama_vaksin)
            ->where('deskripsi', $deskripsi)
            ->where('usia_pemberian', $usia_pemberian)
            ->where('dosis_total', $dosis_total)
            ->where('interval', $interval)
            ->get();
        $this->assertCount(1, $vaksins);
        $vaksin = $vaksins->first();

        $response->assertRedirect(route('vaksin.index'));
        $response->assertSessionHas('vaksin.id', $vaksin->id);
    }


    /**
     * @test
     */
    public function show_displays_view()
    {
        $vaksin = Vaksin::factory()->create();

        $response = $this->get(route('vaksin.show', $vaksin));

        $response->assertOk();
        $response->assertViewIs('vaksin.show');
        $response->assertViewHas('vaksin');
    }


    /**
     * @test
     */
    public function edit_displays_view()
    {
        $vaksin = Vaksin::factory()->create();

        $response = $this->get(route('vaksin.edit', $vaksin));

        $response->assertOk();
        $response->assertViewIs('vaksin.edit');
        $response->assertViewHas('vaksin');
    }


    /**
     * @test
     */
    public function update_uses_form_request_validation()
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\VaksinController::class,
            'update',
            \App\Http\Requests\VaksinUpdateRequest::class
        );
    }

    /**
     * @test
     */
    public function update_redirects()
    {
        $vaksin = Vaksin::factory()->create();
        $nama_vaksin = $this->faker->word;
        $deskripsi = $this->faker->text;
        $usia_pemberian = $this->faker->word;
        $dosis_total = $this->faker->numberBetween(-10000, 10000);
        $interval = $this->faker->word;

        $response = $this->put(route('vaksin.update', $vaksin), [
            'nama_vaksin' => $nama_vaksin,
            'deskripsi' => $deskripsi,
            'usia_pemberian' => $usia_pemberian,
            'dosis_total' => $dosis_total,
            'interval' => $interval,
        ]);

        $vaksin->refresh();

        $response->assertRedirect(route('vaksin.index'));
        $response->assertSessionHas('vaksin.id', $vaksin->id);

        $this->assertEquals($nama_vaksin, $vaksin->nama_vaksin);
        $this->assertEquals($deskripsi, $vaksin->deskripsi);
        $this->assertEquals($usia_pemberian, $vaksin->usia_pemberian);
        $this->assertEquals($dosis_total, $vaksin->dosis_total);
        $this->assertEquals($interval, $vaksin->interval);
    }


    /**
     * @test
     */
    public function destroy_deletes_and_redirects()
    {
        $vaksin = Vaksin::factory()->create();

        $response = $this->delete(route('vaksin.destroy', $vaksin));

        $response->assertRedirect(route('vaksin.index'));

        $this->assertModelMissing($vaksin);
    }
}
