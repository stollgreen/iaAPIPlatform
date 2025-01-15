<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JMac\Testing\Traits\AdditionalAssertions;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

/**
 * @see \App\Http\Controllers\GroupUserController
 */
final class GroupUserControllerTest extends TestCase
{
    use AdditionalAssertions, RefreshDatabase, WithFaker;

    /**
     * @return void
     */
    #[Test]
    public function index_behaves_as_expected(): void
    {
        $groupUsers = GroupUser::factory()->count(3)->create();

        $response = $this->get(route('group-users.index'));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'groupid',
                    'userid',
                ],
            ],
        ]);
    }


    #[Test]
    public function store_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupUserController::class,
            'store',
            \App\Http\Requests\GroupUserStoreRequest::class
        );
    }

    #[Test]
    public function store_saves(): void
    {
        $groupid = Group::factory()->create();
        $userid = User::factory()->create();

        $response = $this->post(route('group-users.store'), [
            'groupid' => $groupid->id,
            'userid' => $userid->id,
        ]);

        $groupUsers = GroupUser::query()
            ->where('groupid', $groupid->id)
            ->where('userid', $userid->id)
            ->get();
        $this->assertCount(1, $groupUsers);
        $groupUser = $groupUsers->first();

        $response->assertCreated();
        $response->assertJsonStructure([
            'data' => [
                'id', 'groupid', 'userid',
            ]
        ]);
    }


    #[Test]
    public function show_behaves_as_expected(): void
    {
        $groupUser = GroupUser::factory()->create();

        $response = $this->get(route('group-users.show', $groupUser));

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'groupid', 'userid',
            ]
        ]);
    }


    #[Test]
    public function update_uses_form_request_validation(): void
    {
        $this->assertActionUsesFormRequest(
            \App\Http\Controllers\GroupUserController::class,
            'update',
            \App\Http\Requests\GroupUserUpdateRequest::class
        );
    }

    #[Test]
    public function update_behaves_as_expected(): void
    {
        $groupUser = GroupUser::factory()->create();
        $groupid = Group::factory()->create();
        $userid = User::factory()->create();

        $response = $this->put(route('group-users.update', $groupUser), [
            'groupid' => $groupid->id,
            'userid' => $userid->id,
        ]);

        $groupUser->refresh();

        $response->assertOk();
        $response->assertJsonStructure([
            'data' => [
                'id', 'groupid', 'userid',
            ]
        ]);

        $this->assertEquals($groupid->id, $groupUser->groupid);
        $this->assertEquals($userid->id, $groupUser->userid);
    }


    #[Test]
    public function destroy_deletes_and_responds_with(): void
    {
        $groupUser = GroupUser::factory()->create();

        $response = $this->delete(route('group-users.destroy', $groupUser));

        $response->assertNoContent();

        $this->assertModelMissing($groupUser);
    }


    #[Test]
    public function methods_behaves_as_expected(): void
    {
        $response = $this->get('api/group-users/methods');
        $response->assertOk();
        $response->assertJson([
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
