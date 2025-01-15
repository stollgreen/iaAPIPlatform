<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ServiceArea;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ServiceAreaController
 */
final class ServiceAreaControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $serviceAreas = ServiceArea::factory()->count(3)->create();

        $response = $this->get(route('service-areas.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'description', 'parent_area_id'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceAreaController::class,
            'store',
            \App\Http\Requests\ServiceAreaStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->post(route('service-areas.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $serviceAreas = ServiceArea::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $serviceAreas);
        $serviceArea = $serviceAreas->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'parent_area_id'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $serviceArea = ServiceArea::factory()->create();

        $response = $this->get(route('service-areas.show', $serviceArea));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'parent_area_id'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ServiceAreaController::class,
            'update',
            \App\Http\Requests\ServiceAreaUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $serviceArea = ServiceArea::factory()->create();
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->put(route('service-areas.update', $serviceArea), [
            'name' => $name,
            'description' => $description,
        ]);

        $serviceArea->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'parent_area_id'
            ]
        ]);

        $this->assertEquals($name, $serviceArea->name);
        $this->assertEquals($description, $serviceArea->description);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $serviceArea = ServiceArea::factory()->create();

        $response = $this->delete(route('service-areas.destroy', $serviceArea));

        $response->assertNoContent();

        $this->assertModelMissing($serviceArea);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/service-areas/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
