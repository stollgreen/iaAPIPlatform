<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Group;
use App\Models\GroupPermission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupPermissionController
 */
final class GroupPermissionControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    #[Test]
    public function index_behaves_as_expected(): void
    {
        $groupPermissions = GroupPermission::factory()->count(3)->create();

        $response = $this->get(route('group-permissions.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id', 'groupid', 'value'
                ]
            ]
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupPermissionController::class,
            'store',
            \App\Http\Requests\GroupPermissionStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $groupid = Group::factory()->create();

        $response = $this->post(route('group-permissions.store'), [
            'groupid' => $groupid->id,
        ]);

        $groupPermissions = GroupPermission::query()
            ->where('groupid', $groupid->id)
            ->get();
        $this->assertCount(1, $groupPermissions);
        $groupPermission = $groupPermissions->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'groupid', 'value',
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $groupPermission = GroupPermission::factory()->create();

        $response = $this->get(route('group-permissions.show', $groupPermission));

        $response->assertOk();
        $response->assertJsonStructure(
            [
                'data' => [
                    'id', 'groupid', 'value',
                ]
            ]
        );
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupPermissionController::class,
            'update',
            \App\Http\Requests\GroupPermissionUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $groupPermission = GroupPermission::factory()->create();
        $groupid = Group::factory()->create();

        $response = $this->put(route('group-permissions.update', $groupPermission), [
            'groupid' => $groupid->id,
        ]);

        $groupPermission->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'groupid', 'value',
            ]
        ]);

        $this->assertEquals($groupid->id, $groupPermission->groupid);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $groupPermission = GroupPermission::factory()->create();

        $response = $this->delete(route('group-permissions.destroy', $groupPermission));

        $response->assertNoContent();

        $this->assertModelMissing($groupPermission);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/group-permissions/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
