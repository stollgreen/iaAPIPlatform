<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Country;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\LocationController
 */
final class LocationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $locations = Location::factory()->count(3)->create();

        $response = $this->get(route('locations.index'));

        $response->assertOk();
        $response->assertJsonStructure(['data' => [
            '*' => ['id', 'name'],
        ]]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocationController::class,
            'store',
            \App\Http\Requests\LocationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->word;

        $response = $this->post(route('locations.store'), [
            'name' => $name,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => Country::factory()->create()->id,
            'postal_code' => $this->faker->postcode,
            'capacity' => $this->faker->randomDigitNotZero(),
        ]);
        $locations = Location::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $locations);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'address', 'city', 'country', 'postal_code', 'capacity'
            ]
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $location = Location::factory()->create();

        $response = $this->get(route('locations.show', $location));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'address', 'city', 'country', 'postal_code', 'capacity'
            ]
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\LocationController::class,
            'update',
            \App\Http\Requests\LocationUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $location = Location::factory()->create();
        $name = $this->faker->word;

        $response = $this->put(route('locations.update', $location), [
            'name' => $name,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => Country::factory()->create()->id,
            'postal_code' => $this->faker->postcode,
            'capacity' => $this->faker->randomDigitNotZero(),
        ]);

        $location->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'address', 'city', 'country', 'postal_code', 'capacity'
            ]
        ]);


        $this->assertEquals($name, $location->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $location = Location::factory()->create();

        $response = $this->delete(route('locations.destroy', $location));

        $response->assertNoContent();

        $this->assertModelMissing($location);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/locations/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}