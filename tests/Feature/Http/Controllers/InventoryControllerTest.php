<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Inventory;
use App\Models\InventoryCondition;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InventoryController
 */
final class InventoryControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $inventories = Inventory::factory()->count(3)->create();

        $response = $this->get(route('inventories.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'type', 'quantity', 'available', 'condition', 'price', 'rental_price'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InventoryController::class,
            'store',
            \App\Http\Requests\InventoryStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $type = $this->faker->word();
        $quantity = $this->faker->randomNumber();
        $available = $this->faker->boolean();
        $condition = InventoryCondition::factory()->create();
        $price = $this->faker->randomNumber();
        $rental_price = $this->faker->randomNumber();

        $response = $this->post(route('inventories.store'), [
            'name' => $name,
            'type' => $type,
            'quantity' => $quantity,
            'available' => $available,
            'condition' => $condition->id,
            'price' => $price,
            'rental_price' => $rental_price,
        ]);
        $inventories = Inventory::query()
            ->where('name', $name)
            ->where('type', $type)
            ->where('quantity', $quantity)
            ->where('available', $available)
            ->where('condition', $condition->id)
            ->where('price', $price)
            ->where('rental_price', $rental_price)
            ->get();
        $this->assertCount(1, $inventories);
        $inventory = $inventories->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'type', 'quantity', 'available', 'condition', 'price', 'rental_price'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $inventory = Inventory::factory()->create();

        $response = $this->get(route('inventories.show', $inventory));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'type', 'quantity', 'available', 'condition', 'price', 'rental_price'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InventoryController::class,
            'update',
            \App\Http\Requests\InventoryUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $inventory = Inventory::factory()->create();
        $name = $this->faker->name();
        $type = $this->faker->word();
        $quantity = $this->faker->randomNumber();
        $available = $this->faker->boolean();
        $condition = InventoryCondition::factory()->create();
        $price = $this->faker->randomNumber();
        $rental_price = $this->faker->randomNumber();

        $response = $this->put(route('inventories.update', $inventory), [
            'name' => $name,
            'type' => $type,
            'quantity' => $quantity,
            'available' => $available,
            'condition' => $condition->id,
            'price' => $price,
            'rental_price' => $rental_price,
        ]);

        $inventory->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'type', 'quantity', 'available', 'condition', 'price', 'rental_price'
            ]
        ]);

        $this->assertEquals($name, $inventory->name);
        $this->assertEquals($type, $inventory->type);
        $this->assertEquals($quantity, $inventory->quantity);
        $this->assertEquals($available, $inventory->available);
        $this->assertEquals($condition->id, $inventory->condition);
        $this->assertEquals($price, $inventory->price);
        $this->assertEquals($rental_price, $inventory->rental_price);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $inventory = Inventory::factory()->create();

        $response = $this->delete(route('inventories.destroy', $inventory));

        $response->assertNoContent();

        $this->assertModelMissing($inventory);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/inventories/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
