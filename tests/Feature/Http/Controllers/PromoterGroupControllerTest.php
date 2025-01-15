<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\PromoterGroup;
use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PromoterGroupController
 */
final class PromoterGroupControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $promoterGroups = PromoterGroup::factory()->count(3)->create();

        $response = $this->get(route('promoter-groups.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'name', 'skills', 'description', 'max_members'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoterGroupController::class,
            'store',
            \App\Http\Requests\PromoterGroupStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        Skill::factory()->count(5)->create();

        $name = $this->faker->name();
        $skills = Skill::inRandomOrder()->take(rand(1, 5))->get()->pluck('id');

        $description = $this->faker->text();
        $max_members = $this->faker->numberBetween(0,5000);

        $response = $this->post(route('promoter-groups.store'), [
            'name' => $name,
            'skills' => $skills,
            'description' => $description,
            'max_members' => $max_members,
        ]);

        $promoterGroups = PromoterGroup::query()
            ->where('name', $name)
            ->where('description', $description)
            ->where('max_members', $max_members)
            ->get();
        $this->assertCount(1, $promoterGroups);
        $promoterGroup = $promoterGroups->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'skills', 'description', 'max_members'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $promoterGroup = PromoterGroup::factory()->create();

        $response = $this->get(route('promoter-groups.show', $promoterGroup));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'skills', 'description', 'max_members'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoterGroupController::class,
            'update',
            \App\Http\Requests\PromoterGroupUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $promoterGroup = PromoterGroup::factory()->create();
        $name = $this->faker->name();
        $skills = $this->faker->word();
        $description = $this->faker->text();
        $max_members = $this->faker->numberBetween(0,5000);

        $response = $this->put(route('promoter-groups.update', $promoterGroup), [
            'name' => $name,
            'skills' => $skills,
            'description' => $description,
            'max_members' => $max_members,
        ]);

        $promoterGroup->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'skills', 'description', 'max_members'
            ]
        ]);

        $this->assertEquals($name, $promoterGroup->name);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $promoterGroup = PromoterGroup::factory()->create();

        $response = $this->delete(route('promoter-groups.destroy', $promoterGroup));

        $response->assertNoContent();

        $this->assertModelMissing($promoterGroup);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/promoter-groups/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
