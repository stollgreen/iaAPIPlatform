<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ContactPerson;
use App\Models\Location;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\ContactPersonController
 */
final class ContactPersonControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $contactPerson = ContactPerson::factory()->count(3)->create();

        $response = $this->get(route('contact-persons.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'email',
                    'phone',
                    'location_id',
                    'role'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactPersonController::class,
            'store',
            \App\Http\Requests\ContactPersonStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $phone = $this->faker->phoneNumber();
        $location = Location::factory()->create();
        $role = $this->faker->word();

        $response = $this->post(route('contact-persons.store'), [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'location_id' => $location->id,
            'role' => $role,
        ]);

        $contactPerson = ContactPerson::query()
            ->where('name', $name)
            ->where('email', $email)
            ->where('phone', $phone)
            ->where('location_id', $location->id)
            ->where('role', $role)
            ->get();
        $this->assertCount(1, $contactPerson);
        $contactPerson = $contactPerson->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'phone', 'location_id', 'role'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $contactPerson = ContactPerson::factory()->create();

        $response = $this->get(route('contact-persons.show', $contactPerson));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'phone', 'location_id', 'role'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\ContactPersonController::class,
            'update',
            \App\Http\Requests\ContactPersonUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $contactPerson = ContactPerson::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $phone = $this->faker->phoneNumber();
        $location = Location::factory()->create();
        $role = $this->faker->word();

        $response = $this->put(route('contact-persons.update', $contactPerson), [
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'location_id' => $location->id,
            'role' => $role,
        ]);

        $contactPerson->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'email', 'phone', 'location_id', 'role'
            ]
        ]);

        $this->assertEquals($name, $contactPerson->name);
        $this->assertEquals($email, $contactPerson->email);
        $this->assertEquals($phone, $contactPerson->phone);
        $this->assertEquals($location->id, $contactPerson->location_id);
        $this->assertEquals($role, $contactPerson->role);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $contactPerson = ContactPerson::factory()->create();

        $response = $this->delete(route('contact-persons.destroy', $contactPerson));

        $response->assertNoContent();

        $this->assertModelMissing($contactPerson);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/contact-persons/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
