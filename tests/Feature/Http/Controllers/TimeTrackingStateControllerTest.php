<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TimeTrackingState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TimeTrackingStateController
 */
final class TimeTrackingStateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $timeTrackingStates = TimeTrackingState::factory()->count(3)->create();

        $response = $this->get(route('time-tracking-states.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'links' => [],
            'meta' => [],
            'data' => [
                '*' => [],
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimeTrackingStateController::class,
            'store',
            \App\Http\Requests\TimeTrackingStateStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('time-tracking-states.store'), [
            'name' => $name,
        ]);

        $timeTrackingStates = TimeTrackingState::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $timeTrackingStates);
        $timeTrackingState = $timeTrackingStates->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ],

        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $timeTrackingState = TimeTrackingState::factory()->create();

        $response = $this->get(route('time-tracking-states.show', $timeTrackingState));

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
            \App\Http\Controllers\TimeTrackingStateController::class,
            'update',
            \App\Http\Requests\TimeTrackingStateUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $timeTrackingState = TimeTrackingState::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('time-tracking-states.update', $timeTrackingState), [
            'name' => $name,
        ]);

        $timeTrackingState->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $timeTrackingState->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $timeTrackingState = TimeTrackingState::factory()->create();

        $response = $this->delete(route('time-tracking-states.destroy', $timeTrackingState));

        $response->assertNoContent();

        $this->assertModelMissing($timeTrackingState);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/time-tracking-states/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
