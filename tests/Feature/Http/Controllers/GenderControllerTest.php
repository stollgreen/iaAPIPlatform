<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Gender;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GenderController
 */
final class GenderControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $genders = Gender::factory()->count(3)->create();

        $response = $this->get(route('genders.index'));

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
            \App\Http\Controllers\GenderController::class,
            'store',
            \App\Http\Requests\GenderStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('genders.store'), [
            'name' => $name,
        ]);

        $genders = Gender::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $genders);
        $gender = $genders->first();

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
        $gender = Gender::factory()->create();

        $response = $this->get(route('genders.show', $gender));

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
            \App\Http\Controllers\GenderController::class,
            'update',
            \App\Http\Requests\GenderUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $gender = Gender::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('genders.update', $gender), [
            'name' => $name,
        ]);

        $gender->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $gender->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $gender = Gender::factory()->create();

        $response = $this->delete(route('genders.destroy', $gender));

        $response->assertNoContent();

        $this->assertModelMissing($gender);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/genders/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
