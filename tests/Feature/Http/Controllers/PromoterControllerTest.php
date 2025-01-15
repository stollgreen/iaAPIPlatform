<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Employee;
use App\Models\Promoter;
use App\Models\PromoterGroup;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PromoterController
 */
final class PromoterControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $promoters = Promoter::factory()->count(3)->create();

        $response = $this->get(route('promoters.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'employee_id', 'promoter_group_id', 'name', 'email', 'phone', 'skills', 'certifications', 'availability'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoterController::class,
            'store',
            \App\Http\Requests\PromoterStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $employee = Employee::factory()->create();
        $promoter_group = PromoterGroup::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $phone = $this->faker->phoneNumber();
        $skills = $this->faker->word();
        $certifications = $this->faker->word();
        $availability = $this->faker->word();

        $response = $this->post(route('promoters.store'), [
            'employee_id' => $employee->id,
            'promoter_group_id' => $promoter_group->id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'skills' => $skills,
            'certifications' => $certifications,
            'availability' => $availability,
        ]);

        $promoters = Promoter::query()
            ->where('employee_id', $employee->id)
            ->where('promoter_group_id', $promoter_group->id)
            ->where('name', $name)
            ->where('email', $email)
            ->where('phone', $phone)
            ->where('skills', $skills)
            ->where('certifications', $certifications)
            ->where('availability', $availability)
            ->get();
        $this->assertCount(1, $promoters);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'employee_id', 'promoter_group_id', 'name', 'email', 'phone', 'skills', 'certifications', 'availability'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $promoter = Promoter::factory()->create();

        $response = $this->get(route('promoters.show', $promoter));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'employee_id', 'promoter_group_id', 'name', 'email', 'phone', 'skills', 'certifications', 'availability'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PromoterController::class,
            'update',
            \App\Http\Requests\PromoterUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $promoter = Promoter::factory()->create();
        $employee = Employee::factory()->create();
        $promoter_group = PromoterGroup::factory()->create();
        $name = $this->faker->name();
        $email = $this->faker->safeEmail();
        $phone = $this->faker->phoneNumber();
        $skills = $this->faker->word();
        $certifications = $this->faker->word();
        $availability = $this->faker->word();

        $response = $this->put(route('promoters.update', $promoter), [
            'employee_id' => $employee->id,
            'promoter_group_id' => $promoter_group->id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'skills' => $skills,
            'certifications' => $certifications,
            'availability' => $availability,
        ]);

        $promoter->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'employee_id', 'promoter_group_id', 'name', 'email', 'phone', 'skills', 'certifications', 'availability'
            ]
        ]);

        $this->assertEquals($employee->id, $promoter->employee_id);
        $this->assertEquals($promoter_group->id, $promoter->promoter_group_id);
        $this->assertEquals($name, $promoter->name);
        $this->assertEquals($email, $promoter->email);
        $this->assertEquals($phone, $promoter->phone);
        $this->assertEquals($skills, $promoter->skills);
        $this->assertEquals($certifications, $promoter->certifications);
        $this->assertEquals($availability, $promoter->availability);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $promoter = Promoter::factory()->create();

        $response = $this->delete(route('promoters.destroy', $promoter));

        $response->assertNoContent();

        $this->assertModelMissing($promoter);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/promoters/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
