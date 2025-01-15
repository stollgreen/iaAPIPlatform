<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\EventState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventStateController
 */
final class EventStateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $eventStates = EventState::factory()->count(3)->create();

        $response = $this->get(route('event-states.index'));

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
            \App\Http\Controllers\EventStateController::class,
            'store',
            \App\Http\Requests\EventStateStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('event-states.store'), [
            'name' => $name,
        ]);

        $eventStates = EventState::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $eventStates);
        $eventState = $eventStates->first();

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
        $eventState = EventState::factory()->create();

        $response = $this->get(route('event-states.show', $eventState));

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
            \App\Http\Controllers\EventStateController::class,
            'update',
            \App\Http\Requests\EventStateUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $eventState = EventState::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('event-states.update', $eventState), [
            'name' => $name,
        ]);

        $eventState->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $eventState->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $eventState = EventState::factory()->create();

        $response = $this->delete(route('event-states.destroy', $eventState));

        $response->assertNoContent();

        $this->assertModelMissing($eventState);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/event-states/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
