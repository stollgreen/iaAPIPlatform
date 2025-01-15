<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\Event;
use App\Models\Occupation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\OccupationController
 */
final class OccupationControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $occupations = Occupation::factory()->count(3)->create();

        $response = $this->get(route('occupations.index'));

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
            \App\Http\Controllers\OccupationController::class,
            'store',
            \App\Http\Requests\OccupationStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->jobTitle;

        $response = $this->post(route('occupations.store'), [
            'name' => $name,
            'description' => $this->faker->text,
            'required_skills' => $this->faker->text,
            'hourly_rate' => $this->faker->randomFloat(2, 0, 1000),
            'event' => Event::factory()->create()->id,
        ]);

        $occupations = Occupation::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $occupations);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'required_skills', 'hourly_rate', 'event'
            ]
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $occupation = Occupation::factory()->create();

        $response = $this->get(route('occupations.show', $occupation));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'required_skills', 'hourly_rate', 'event'
            ]
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\OccupationController::class,
            'update',
            \App\Http\Requests\OccupationUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $occupation = Occupation::factory()->create();
        $name = $this->faker->jobTitle;

        $response = $this->put(route('occupations.update', $occupation), [
            'name' => $name,
            'description' => $this->faker->text,
            'required_skills' => $this->faker->text,
            'hourly_rate' => $this->faker->randomFloat(2, 0, 1000),
            'event' => Event::factory()->create()->id,
        ]);

        $occupation->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description', 'required_skills', 'hourly_rate', 'event'
            ]
        ]);


        $this->assertEquals($name, $occupation->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $occupation = Occupation::factory()->create();

        $response = $this->delete(route('occupations.destroy', $occupation));

        $response->assertNoContent();

        $this->assertModelMissing($occupation);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/occupations/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}