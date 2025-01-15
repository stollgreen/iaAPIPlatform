<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Commitment;
use App\Models\Employee;
use App\Models\TimeTracking;
use App\Models\TimeTrackingChannel;
use App\Models\TimeTrackingState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TimeTrackingController
 */
final class TimeTrackingControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $timeTrackings = TimeTracking::factory()->count(3)->create();

        $response = $this->get(route('time-trackings.index'));

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimeTrackingController::class,
            'store',
            \App\Http\Requests\TimeTrackingStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $employee = Employee::factory()->create();
        $commitment = Commitment::factory()->create();
        $time_tracking_channel = TimeTrackingChannel::factory()->create();
        $time_tracking_state = TimeTrackingState::factory()->create();
        $start_time = $this->faker->dateTime()->format('Y-m-d H:i:s');
        $end_time = $this->faker->dateTimeBetween($start_time, '+8 hours')->format('Y-m-d H:i:s');

        $response = $this->post(route('time-trackings.store'), [
            'employee_id' => $employee->id,
            'commitment_id' => $commitment->id,
            'time_tracking_channel_id' => $time_tracking_channel->id,
            'time_tracking_state_id' => $time_tracking_state->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);

        $timeTrackings = TimeTracking::query()
            ->where('employee_id', $employee->id)
            ->where('commitment_id', $commitment->id)
            ->where('time_tracking_channel_id', $time_tracking_channel->id)
            ->where('time_tracking_state_id', $time_tracking_state->id)
            ->where('start_time', $start_time)
            ->where('end_time', $end_time)
            ->get();
        $this->assertCount(1, $timeTrackings);
        $timeTracking = $timeTrackings->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'employee_id',
                'commitment_id',
                'time_tracking_channel_id',
                'time_tracking_state_id',
                'start_time',
                'end_time',
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $timeTracking = TimeTracking::factory()->create();

        $response = $this->get(route('time-trackings.show', $timeTracking));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id',
                'employee_id',
                'commitment_id',
                'time_tracking_channel_id',
                'time_tracking_state_id',
                'start_time',
                'end_time',
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimeTrackingController::class,
            'update',
            \App\Http\Requests\TimeTrackingUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $timeTracking = TimeTracking::factory()->create();
        $employee = Employee::factory()->create();
        $commitment = Commitment::factory()->create();
        $time_tracking_channel = TimeTrackingChannel::factory()->create();
        $time_tracking_state = TimeTrackingState::factory()->create();
        $start_time = $this->faker->dateTime()->format('Y-m-d H:i:s');
        $end_time = $this->faker->dateTimeBetween($start_time, '+8 hours')->format('Y-m-d H:i:s');

        $response = $this->put(route('time-trackings.update', $timeTracking), [
            'employee_id' => $employee->id,
            'commitment_id' => $commitment->id,
            'time_tracking_channel_id' => $time_tracking_channel->id,
            'time_tracking_state_id' => $time_tracking_state->id,
            'start_time' => $start_time,
            'end_time' => $end_time,
        ]);

        $timeTracking->refresh();

        $response->assertOk();
        $response->assertJsonStructure([]);

        $this->assertEquals($employee->id, $timeTracking->employee_id);
        $this->assertEquals($commitment->id, $timeTracking->commitment_id);
        $this->assertEquals($time_tracking_channel->id, $timeTracking->time_tracking_channel_id);
        $this->assertEquals($time_tracking_state->id, $timeTracking->time_tracking_state_id);
        $this->assertEquals($start_time, $timeTracking->start_time);
        $this->assertEquals($end_time, $timeTracking->end_time);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $timeTracking = TimeTracking::factory()->create();

        $response = $this->delete(route('time-trackings.destroy', $timeTracking));

        $response->assertNoContent();

        $this->assertModelMissing($timeTracking);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get("api/time-trackings/methods");
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
