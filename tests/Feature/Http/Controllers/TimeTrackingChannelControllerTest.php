<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\TimeTrackingChannel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\TimeTrackingChannelController
 */
final class TimeTrackingChannelControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $timeTrackingChannels = TimeTrackingChannel::factory()->count(3)->create();

        $response = $this->get('api/time-tracking-channels/methods'); // Direkter URI-Aufruf

        $response->assertOk();
        $response->assertJsonStructure([]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimeTrackingChannelController::class,
            'store',
            \App\Http\Requests\TimeTrackingChannelStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $active = $this->faker->boolean();

        $response = $this->post('api/time-tracking-channels', [
            'name' => $name,
            'active' => $active,
        ]);

        $timeTrackingChannels = TimeTrackingChannel::query()
            ->where('name', $name)
            ->where('active', $active)
            ->get();
        $this->assertCount(1, $timeTrackingChannels);
        $timeTrackingChannel = $timeTrackingChannels->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'active'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $timeTrackingChannel = TimeTrackingChannel::factory()->create();

        $response = $this->get(route('time-tracking-channels.show', $timeTrackingChannel));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'active'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\TimeTrackingChannelController::class,
            'update',
            \App\Http\Requests\TimeTrackingChannelUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $timeTrackingChannel = TimeTrackingChannel::factory()->create();
        $name = $this->faker->name();
        $active = $this->faker->boolean();

        $response = $this->put(route('time-tracking-channels.update', $timeTrackingChannel), [
            'name' => $name,
            'active' => $active,
        ]);

        $timeTrackingChannel->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'active'
            ]
        ]);

        $this->assertEquals($name, $timeTrackingChannel->name);
        $this->assertEquals($active, $timeTrackingChannel->active);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $timeTrackingChannel = TimeTrackingChannel::factory()->create();

        $response = $this->delete(route('time-tracking-channels.destroy', $timeTrackingChannel));

        $response->assertNoContent();

        $this->assertModelMissing($timeTrackingChannel);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get("api/time-tracking-channels/methods");
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
