<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\Event;
use App\Models\Offer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 *
 * @see \App\Http\Controllers\OfferController
 */
final class OfferControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $offers = Offer::factory()->count(3)->create();

        $response = $this->get(route('offers.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'event_id', 'customer_id', 'description', 'total_price', 'status'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OfferController::class,
            'store',
            \App\Http\Requests\OfferStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $description = $this->faker->text();
        $total_price = $this->faker->numberBetween(0,10000);

        $response = $this->post(route('offers.store'), [
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'description' => $description,
            'total_price' => $total_price,

        ]);

        $offers = Offer::query()
            ->where('event_id', $event->id)
            ->where('customer_id', $customer->id)
            ->get();
        $this->assertCount(1, $offers);
        $offer = $offers->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'event_id', 'customer_id', 'description', 'total_price', 'status'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $offer = Offer::factory()->create();

        $response = $this->get(route('offers.show', $offer));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'event_id', 'customer_id', 'description', 'total_price', 'status'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OfferController::class,
            'update',
            \App\Http\Requests\OfferUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $offer = Offer::factory()->create();
        $event = Event::factory()->create();
        $customer = Customer::factory()->create();
        $description = $this->faker->text();
        $total_price = $this->faker->numberBetween(0,10000);

        $response = $this->put(route('offers.update', $offer), [
            'event_id' => $event->id,
            'customer_id' => $customer->id,
            'description' => $description,
            'total_price' => $total_price,
            'status' => null
        ]);

        $offer->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'event_id', 'customer_id', 'description', 'total_price', 'status'
            ]
        ]);

        $this->assertEquals($event->id, $offer->event_id);
        $this->assertEquals($customer->id, $offer->customer_id);
        $this->assertEquals($description, $offer->description);
        $this->assertEquals($total_price, $offer->total_price);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $offer = Offer::factory()->create();

        $response = $this->delete(route('offers.destroy', $offer));

        $response->assertNoContent();

        $this->assertModelMissing($offer);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/offers/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
