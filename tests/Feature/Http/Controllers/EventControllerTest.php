<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Event;
use App\Models\EventState;
use App\Models\Location;
use Database\Factories\EventStateFactory;
use Database\Factories\LocationFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EventController
 */
final class EventControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $events = Event::factory()->count(3)->create();

        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'date', 'location_id', 'organizer', 'budget', 'status'
                ]
            ]
        ]);

    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'store',
            \App\Http\Requests\EventStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->word;
        $date = now()->toDateString();  // Gibt das heutige Datum im Format 'YYYY-MM-DD' zurück
        $locationId = Location::factory()->create()->id;

        // Event speichern
        $response = $this->post(route('events.store'), [
            'name' => $name,
            'date' => $date,
            'location_id' => $locationId,
            'organizer' => $this->faker->word,
            'budget' => $this->faker->randomFloat(2, 0, 1000),
            'status' => EventState::factory()->create()->id,
        ]);

        $events = Event::query()
            ->where('name', $name)
            ->where('date', $date)
            ->where('location_id', $locationId)
            ->get();

        $this->assertCount(1, $events);  // Stellen Sie sicher, dass genau 1 Event in der DB existiert

        // Überprüfen, ob die Antwort den Status '201 Created' hat
        $response->assertCreated();

        // Sicherstellen, dass die Struktur der JSON-Antwort den Event-Daten entspricht
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'date', 'location_id', 'organizer', 'budget', 'status'
            ]
        ]);
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $event = Event::factory()->create();

        $response = $this->get(route('events.show', $event));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'date', 'location_id', 'organizer', 'budget', 'status'
            ]
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EventController::class,
            'update',
            \App\Http\Requests\EventUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $event = Event::factory()->create();
        $name = $this->faker->word;
        $date = now()->toDateString();  // Gibt das heutige Datum im Format 'YYYY-MM-DD' zurück

        $response = $this->put(route('events.update', $event), [
            'name' => $name,
            'date' => $date,
            'location_id' => Location::factory()->create()->id,
            'organizer' => $this->faker->word,
            'budget' => $this->faker->randomFloat(2, 0, 1000),
            'status' => EventState::factory()->create()->id,
        ]);

        $event->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'date', 'location_id', 'organizer', 'budget', 'status'
            ]
        ]);


        $this->assertEquals($name, $event->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $event = Event::factory()->create();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertNoContent();

        $this->assertModelMissing($event);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/events/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}