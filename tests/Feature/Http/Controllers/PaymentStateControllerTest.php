<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PaymentState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PaymentStateController
 */
final class PaymentStateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $paymentStates = PaymentState::factory()->count(3)->create();

        $response = $this->get(route('payment-states.index'));

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
            \App\Http\Controllers\PaymentStateController::class,
            'store',
            \App\Http\Requests\PaymentStateStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('payment-states.store'), [
            'name' => $name,
        ]);

        $paymentStates = PaymentState::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $paymentStates);
        $paymentState = $paymentStates->first();

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
        $paymentState = PaymentState::factory()->create();

        $response = $this->get(route('payment-states.show', $paymentState));

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
            \App\Http\Controllers\PaymentStateController::class,
            'update',
            \App\Http\Requests\PaymentStateUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $paymentState = PaymentState::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('payment-states.update', $paymentState), [
            'name' => $name,
        ]);

        $paymentState->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $paymentState->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $paymentState = PaymentState::factory()->create();

        $response = $this->delete(route('payment-states.destroy', $paymentState));

        $response->assertNoContent();

        $this->assertModelMissing($paymentState);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/payment-states/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
