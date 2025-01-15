<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\OfferState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OfferStateController
 */
final class OfferStateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $offerStates = OfferState::factory()->count(3)->create();

        $response = $this->get(route('offer-states.index'));

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
            \App\Http\Controllers\OfferStateController::class,
            'store',
            \App\Http\Requests\OfferStateStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('offer-states.store'), [
            'name' => $name,
        ]);


        $offerStates = OfferState::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $offerStates);
        $offerState = $offerStates->first();

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
        $offerState = OfferState::factory()->create();

        $response = $this->get(route('offer-states.show', $offerState));

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
            \App\Http\Controllers\OfferStateController::class,
            'update',
            \App\Http\Requests\OfferStateUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $offerState = OfferState::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('offer-states.update', $offerState), [
            'name' => $name,
        ]);

        $offerState->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $offerState->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $offerState = OfferState::factory()->create();

        $response = $this->delete(route('offer-states.destroy', $offerState));

        $response->assertNoContent();

        $this->assertModelMissing($offerState);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/offer-states/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
