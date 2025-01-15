<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\PermissionController
 */
final class PermissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $permissions = Permission::factory()->count(3)->create();

        $response = $this->get(route('permissions.index'));

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
            \App\Http\Controllers\PermissionController::class,
            'store',
            \App\Http\Requests\PermissionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->post(route('permissions.store'), [
            'name' => $name,
            'description' => $description,
        ]);

        $permissions = Permission::query()
            ->where('name', $name)
            ->where('description', $description)
            ->get();
        $this->assertCount(1, $permissions);
        $permission = $permissions->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description'
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $permission = Permission::factory()->create();

        $response = $this->get(route('permissions.show', $permission));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description'
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\PermissionController::class,
            'update',
            \App\Http\Requests\PermissionUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $permission = Permission::factory()->create();
        $name = $this->faker->name();
        $description = $this->faker->text();

        $response = $this->put(route('permissions.update', $permission), [
            'name' => $name,
            'description' => $description,
        ]);

        $permission->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'name', 'description'
            ]
        ]);

        $this->assertEquals($name, $permission->name);
        $this->assertEquals($description, $permission->description);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $permission = Permission::factory()->create();

        $response = $this->delete(route('permissions.destroy', $permission));

        $response->assertNoContent();

        $this->assertModelMissing($permission);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/permissions/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
