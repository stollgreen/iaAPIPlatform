<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\CommitmentState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\CommitmentStateController
 */
final class CommitmentStateControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $commitmentStates = CommitmentState::factory()->count(3)->create();

        $response = $this->get(route('commitment-states.index'));
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
            \App\Http\Controllers\CommitmentStateController::class,
            'store',
            \App\Http\Requests\CommitmentStateStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();

        $response = $this->post(route('commitment-states.store'), [
            'name' => $name,

        ]);

        $commitmentStates = CommitmentState::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $commitmentStates);
        $commitmentState = $commitmentStates->first();

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
        $commitmentState = CommitmentState::factory()->create();

        $response = $this->get(route('commitment-states.show', $commitmentState));

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
            \App\Http\Controllers\CommitmentStateController::class,
            'update',
            \App\Http\Requests\CommitmentStateUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $commitmentState = CommitmentState::factory()->create();
        $name = $this->faker->name();

        $response = $this->put(route('commitment-states.update', $commitmentState), [
            'name' => $name,
        ]);

        $commitmentState->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name'
            ]
        ]);

        $this->assertEquals($name, $commitmentState->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $commitmentState = CommitmentState::factory()->create();

        $response = $this->delete(route('commitment-states.destroy', $commitmentState));

        $response->assertNoContent();

        $this->assertModelMissing($commitmentState);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/commitment-states/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
