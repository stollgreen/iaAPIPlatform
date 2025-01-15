<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Offer;
use App\Models\PaymentState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\InvoiceController
 */
final class InvoiceControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $invoices = Invoice::factory()->count(3)->create();

        $response = $this->get(route('invoices.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'offer_id', 'customer_id', 'issue_date', 'due_date', 'total_amount', 'payment_status'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InvoiceController::class,
            'store',
            \App\Http\Requests\InvoiceStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $offer = Offer::factory()->create();
        $customer = Customer::factory()->create();
        $issue_date = Carbon::parse($this->faker->date());
        $due_date = Carbon::parse($this->faker->date());
        $total_amount = $this->faker->numberBetween(0, 10000);
        $payment_status = PaymentState::factory()->create();

        $response = $this->post(route('invoices.store'), [
            'offer_id' => $offer->id,
            'customer_id' => $customer->id,
            'issue_date' => $issue_date->toDateString(),
            'due_date' => $due_date->toDateString(),
            'total_amount' => $total_amount,
            'payment_status' => $payment_status->id,
        ]);

        $invoices = Invoice::query()
            ->where('offer_id', $offer->id)
            ->where('customer_id', $customer->id)
            ->where('issue_date', $issue_date)
            ->where('due_date', $due_date)
            ->where('total_amount', $total_amount)
            ->where('payment_status', $payment_status->id)
            ->get();
        $this->assertCount(1, $invoices);
        $invoice = $invoices->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'offer_id', 'customer_id', 'issue_date', 'due_date', 'total_amount', 'payment_status'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->get(route('invoices.show', $invoice));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'offer_id', 'customer_id', 'issue_date', 'due_date', 'total_amount', 'payment_status'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\InvoiceController::class,
            'update',
            \App\Http\Requests\InvoiceUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $invoice = Invoice::factory()->create();
        $offer = Offer::factory()->create();
        $customer = Customer::factory()->create();
        $issue_date = Carbon::parse($this->faker->date());
        $due_date = Carbon::parse($this->faker->date());
        $total_amount = $this->faker->numberBetween(0, 10000);
        $payment_status = PaymentState::factory()->create();

        $response = $this->put(route('invoices.update', $invoice), [
            'offer_id' => $offer->id,
            'customer_id' => $customer->id,
            'issue_date' => $issue_date->toDateString(),
            'due_date' => $due_date->toDateString(),
            'total_amount' => $total_amount,
            'payment_status' => $payment_status->id,
        ]);

        $invoice->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'offer_id', 'customer_id', 'issue_date', 'due_date', 'total_amount', 'payment_status'
            ]
        ]);

        $this->assertEquals($offer->id, $invoice->offer_id);
        $this->assertEquals($customer->id, $invoice->customer_id);
        $this->assertEquals($issue_date, $invoice->issue_date);
        $this->assertEquals($due_date, $invoice->due_date);
        $this->assertEquals($total_amount, $invoice->total_amount);
        $this->assertEquals($payment_status->id, $invoice->payment_status);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $invoice = Invoice::factory()->create();

        $response = $this->delete(route('invoices.destroy', $invoice));

        $response->assertNoContent();

        $this->assertModelMissing($invoice);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/invoices/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
