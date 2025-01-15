<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\EmployeeController
 */
final class EmployeeControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $employees = Employee::factory()->count(3)->create();

        $response = $this->get(route('employees.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'phone',
                    'address_line_1' ,
                    'address_line_2',
                    'post_code',
                    'city',
                    'country',
                    'hire_date',
                    'birth_date',
                    'gender',
                    'position',
                    'department_id',
                    'salary',
                ]
            ]
        ]);

    }

    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'store',
            \App\Http\Requests\EmployeeStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $email = $this->faker->safeEmail();
        $departmentId = Department::factory()->create()->id;

        $response = $this->post(route('employees.store'), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'department_id' => $departmentId,
            'salary' => null
        ]);

        $employees = Employee::query()
            ->where('last_name', $last_name)
            ->where('first_name', $first_name)
            ->where('email', $email)
            ->where('department_id', $departmentId)
            ->get();
        $this->assertCount(1, $employees);

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'first_name', 'last_name', 'email', 'department_id', 'salary'
            ]
        ]);

    }

    #[Test]
    public function show_behaves_as_expected(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->get(route('employees.show', $employee));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'first_name', 'last_name', 'email', 'department_id', 'salary'
            ]
        ]);

    }

    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\EmployeeController::class,
            'update',
            \App\Http\Requests\EmployeeUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $employee = Employee::factory()->create();
        $first_name = $this->faker->firstName();
        $last_name = $this->faker->lastName();
        $email = $this->faker->safeEmail();
        $departmentId = Department::factory()->create()->id;

        $response = $this->put(route('employees.update', $employee), [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email,
            'department_id' => $departmentId,
            'salary' => null
        ]);

        $employee->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'first_name', 'last_name', 'email', 'department_id', 'salary'
            ]
        ]);


        $this->assertEquals($last_name, $employee->last_name);
        $this->assertEquals($email, $employee->email);
    }

    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $employee = Employee::factory()->create();

        $response = $this->delete(route('employees.destroy', $employee));

        $response->assertNoContent();

        $this->assertModelMissing($employee);
    }

    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('/api/employees/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}