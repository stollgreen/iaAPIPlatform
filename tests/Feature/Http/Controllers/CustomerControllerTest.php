<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CustomerController
 */
final class CustomerControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $customers = Customer::factory()->count(3)->create();

        $response = $this->get(route('customers.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'company_name',
                    'email',
                    'phone',
                    'address_line_1' ,
                    'address_line_2',
                    'post_code',
                    'city',
                    'country',
                    'vat_number',
                ]
            ]
        ]);

    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CustomerController::class,
            'store',
            \App\Http\Requests\CustomerStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();

        $response = $this->post(route('customers.store'), [
            'name' => $name,
            'email' => $email,
            'company_name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'vat_number' => $this->faker->numerify("###/#####/#####")
        ]);

        $customers = Customer::query()
            ->where('name', $name)
            ->where('email', $email)
            ->get();
        $this->assertCount(1, $customers);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'company_name', 'email', 'phone', 'vat_number'
            ]
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->get(route('customers.show', $customer));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'company_name', 'email', 'phone', 'vat_number'
            ]
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CustomerController::class,
            'update',
            \App\Http\Requests\CustomerUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $customer = Customer::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();

        $response = $this->put(route('customers.update', $customer), [
            'name' => $name,
            'email' => $email,
            'company_name' => $this->faker->company(),
            'phone' => $this->faker->phoneNumber(),
            'vat_number' => $this->faker->numerify("###/#####/#####")
        ]);

        $customer->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'company_name', 'email', 'phone', 'vat_number'
            ]
        ]);


        $this->assertEquals($name, $customer->name);
        $this->assertEquals($email, $customer->email);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $customer = Customer::factory()->create();

        $response = $this->delete(route('customers.destroy', $customer));

        $response->assertNoContent();

        $this->assertModelMissing($customer);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/customers/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}