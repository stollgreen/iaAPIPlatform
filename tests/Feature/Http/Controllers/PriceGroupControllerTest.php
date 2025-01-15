<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PriceGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PriceGroupController
 */
final class PriceGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $priceGroups = PriceGroup::factory()->count(3)->create();

        $response = $this->get(route('price-groups.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'description', 'discount', 'currency'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PriceGroupController::class,
            'store',
            \App\Http\Requests\PriceGroupStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->text();
        $discount = $this->faker->word();
        $currency = $this->faker->word();

        $response = $this->post(route('price-groups.store'), [
            'name' => $name,
            'description' => $description,
            'discount' => $discount,
            'currency' => $currency,
        ]);

        $priceGroups = PriceGroup::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('discount', $discount)
            ->where('currency', $currency)
            ->get();
        $this->assertCount(1, $priceGroups);
        $priceGroup = $priceGroups->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'discount', 'currency'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $priceGroup = PriceGroup::factory()->create();

        $response = $this->get(route('price-groups.show', $priceGroup));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'discount', 'currency'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PriceGroupController::class,
            'update',
            \App\Http\Requests\PriceGroupUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $priceGroup = PriceGroup::factory()->create();
        $name = $this->faker->name();
        $description = $this->faker->text();
        $discount = $this->faker->word();
        $currency = $this->faker->word();

        $response = $this->put(route('price-groups.update', $priceGroup), [
            'name' => $name,
            'description' => $description,
            'discount' => $discount,
            'currency' => $currency,
        ]);

        $priceGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
           'data' => [
               'id', 'name', 'description', 'discount', 'currency'
           ]
        ]);

        $this->assertEquals($name, $priceGroup->name);
        $this->assertEquals($description, $priceGroup->description);
        $this->assertEquals($currency, $priceGroup->currency);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $priceGroup = PriceGroup::factory()->create();

        $response = $this->delete(route('price-groups.destroy', $priceGroup));

        $response->assertNoContent();

        $this->assertModelMissing($priceGroup);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/price-groups/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
