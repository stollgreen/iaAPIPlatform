<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commitment;
use App\Models\Event;
use App\Models\Promoter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommitmentController
 */
final class CommitmentControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $commitments = Commitment::factory()->count(3)->create();
        $response = $this->get(route('commitments.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'promoter_id',
                    'event_id',
                    'role',
                    'start_time',
                    'end_time',
                    'status',
                ],
            ],
        ]);
    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitmentController::class,
            'store',
            \App\Http\Requests\CommitmentStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $promoter = Promoter::factory()->create();
        $event = Event::factory()->create();
        $role = $this->faker->word();
        $start_time = Carbon::parse(now()->addDays(10));
        $end_time = Carbon::parse(now()->addDays(40));

        $response = $this->post(route('commitments.store'), [
            'promoter_id' => $promoter->id,
            'event_id' => $event->id,
            'role' => $role,
            'start_time' => $start_time->toDateTimeString(),
            'end_time' => $end_time->toDateTimeString(),
        ]);


        $commitments = Commitment::query()
            ->where('promoter_id', $promoter->id)
            ->where('event_id', $event->id)
            ->where('role', $role)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->get();


        $this->assertCount(1, $commitments);
        $commitment = $commitments->first();

        $response->assertCreated();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id', 'promoter_id', 'event_id', 'role', 'start_time', 'end_time', 'status',
                ]
            ]
        );
    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $commitment = Commitment::factory()->create();

        $response = $this->get(route('commitments.show', $commitment));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'promoter_id', 'event_id', 'role', 'start_time', 'end_time', 'status',
            ]
        ]);
    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\CommitmentController::class,
            'update',
            \App\Http\Requests\CommitmentUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $commitment = Commitment::factory()->create();
        $promoter = Promoter::factory()->create();
        $event = Event::factory()->create();
        $role = $this->faker->word();
        $start_time = Carbon::parse(now()->addDays(10));
        $end_time = Carbon::parse(now()->addDays(40));

        $response = $this->put(route('commitments.update', $commitment), [
            'promoter_id' => $promoter->id,
            'event_id' => $event->id,
            'role' => $role,
            'start_time' => $start_time->toDateTimeString(),
            'end_time' => $end_time->toDateTimeString(),
        ]);

        $commitment->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'promoter_id', 'event_id', 'role', 'start_time', 'end_time', 'status',
            ]
        ]);

        $this->assertEquals($promoter->id, $commitment->promoter_id);
        $this->assertEquals($event->id, $commitment->event_id);
        $this->assertEquals($role, $commitment->role);
        $this->assertEquals(
            $start_time->format('Y-m-d H:i:s'),
            $commitment->start_time->format('Y-m-d H:i:s')
        );

        $this->assertEquals(
            $end_time->format('Y-m-d H:i:s'),
            $commitment->end_time->format('Y-m-d H:i:s')
        );
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $commitment = Commitment::factory()->create();

        $response = $this->delete(route('commitments.destroy', $commitment));

        $response->assertNoContent();

        $this->assertModelMissing($commitment);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/commitments/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
