<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\SkillController
 */
final class SkillControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $skills = Skill::factory()->count(3)->create();

        $response = $this->get(route('skills.index'));

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
            \App\Http\Controllers\SkillController::class,
            'store',
            \App\Http\Requests\SkillStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->word;
        $description = $this->faker->sentence;
        $category = $this->faker->word;
        $required_certification = $this->faker->word;

        $response = $this->post(route('skills.store'), [
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'required_certification' => $required_certification,
        ]);

        $skills = Skill::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $skills);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => ['description', 'category', 'required_certification']
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->get(route('skills.show', $skill));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['description', 'category', 'required_certification']
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\SkillController::class,
            'update',
            \App\Http\Requests\SkillUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $skill = Skill::factory()->create();
        $name = $this->faker->word;
        $description = $this->faker->sentence;

        $response = $this->put(route('skills.update', $skill), [
            'name' => $name,
            'description' => $description,
            'category' => $this->faker->word,
            'required_certification' => $this->faker->word,
        ]);

        $skill->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => ['description', 'category', 'required_certification']
        ]);


        $this->assertEquals($name, $skill->name);
        $this->assertEquals($description, $skill->description);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $skill = Skill::factory()->create();

        $response = $this->delete(route('skills.destroy', $skill));

        $response->assertNoContent();

        $this->assertModelMissing($skill);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/skills/methods');

        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}