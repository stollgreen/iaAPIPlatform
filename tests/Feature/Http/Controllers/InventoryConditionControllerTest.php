<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\InventoryCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InventoryConditionController
 */
final class InventoryConditionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $inventoryConditions = InventoryCondition::factory()->count(3)->create();

        $response = $this->get(route('inventory-conditions.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InventoryConditionController::class,
            'store',
            \App\Http\Requests\InventoryConditionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('inventory-conditions.store'), [
            'name' => $name,
        ]);

        $inventoryConditions = InventoryCondition::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $inventoryConditions);
        $inventoryCondition = $inventoryConditions->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $inventoryCondition = InventoryCondition::factory()->create();

        $response = $this->get(route('inventory-conditions.show', $inventoryCondition));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InventoryConditionController::class,
            'update',
            \App\Http\Requests\InventoryConditionUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $inventoryCondition = InventoryCondition::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('inventory-conditions.update', $inventoryCondition), [
            'name' => $name,
        ]);

        $inventoryCondition->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $inventoryCondition->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $inventoryCondition = InventoryCondition::factory()->create();

        $response = $this->delete(route('inventory-conditions.destroy', $inventoryCondition));

        $response->assertNoContent();

        $this->assertModelMissing($inventoryCondition);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/inventory-conditions/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
