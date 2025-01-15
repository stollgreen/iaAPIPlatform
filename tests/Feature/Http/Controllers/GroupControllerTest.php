<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Group;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupController
 */
final class GroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $groups = Group::factory()->count(3)->create();

        $response = $this->get(route('groups.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'description'
                ]
            ]
        ]);

    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'store',
            \App\Http\Requests\GroupStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->word;

        $response = $this->post(route('groups.store'), [
            'name' => $name,
            'description' => $this->faker()->word
        ]);

        $groups = Group::query()
            ->where('name', $name)
            ->get();
        $this->assertCount(1, $groups);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['description', 'name']
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $group = Group::factory()->create();

        $response = $this->get(route('groups.show', $group));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['description', 'name']
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupController::class,
            'update',
            \App\Http\Requests\GroupUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $group = Group::factory()->create();
        $name = $this->faker->word;

        $response = $this->put(route('groups.update', $group), [
            'name' => $name,
            'description' => $this->faker()->word,
        ]);

        $group->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['description', 'name']
        ]);


        $this->assertEquals($name, $group->name);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $group = Group::factory()->create();

        $response = $this->delete(route('groups.destroy', $group));

        $response->assertNoContent();

        $this->assertModelMissing($group);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/groups/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}