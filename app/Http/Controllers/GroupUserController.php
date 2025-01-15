<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupUserStoreRequest;
use App\Http\Requests\GroupUserUpdateRequest;
use App\Http\Resources\GroupUserCollection;
use App\Http\Resources\GroupUserResource;
use App\Models\GroupUser;
use Illuminate\Http\JsonResponse;

/**
 * Class GroupUserController
 *
 * This controller manages operations for group-user associations, including
 * listing, creating, reading, updating, and deleting group-user records.
 * It also specifies supported HTTP methods for the resource.
 */
class GroupUserController extends Controller
{
    /**
     * Display a listing of the group-user associations.
     *
     * @return GroupUserCollection
     */
    public function index(): GroupUserCollection
    {
        $groupUsers = GroupUser::paginate(request()->input('perPage'));
        return new GroupUserCollection($groupUsers);
    }

    /**
     * Store a newly created group-user association in storage.
     *
     * @param GroupUserStoreRequest $request
     * @return GroupUserResource
     */
    public function store(GroupUserStoreRequest $request): GroupUserResource
    {
        $groupUser = GroupUser::create($request->validated());
        return new GroupUserResource($groupUser);
    }

    /**
     * Display the specified group-user association.
     *
     * @param GroupUser $groupUser
     * @return GroupUserResource
     */
    public function show(GroupUser $groupUser): GroupUserResource
    {
        return new GroupUserResource($groupUser);
    }

    /**
     * Update the specified group-user association in storage.
     *
     * @param GroupUserUpdateRequest $request
     * @param GroupUser $groupUser
     * @return GroupUserResource
     */
    public function update(GroupUserUpdateRequest $request, GroupUser $groupUser): GroupUserResource
    {
        $groupUser->update($request->validated());
        return new GroupUserResource($groupUser);
    }

    /**
     * Remove the specified group-user association from storage.
     *
     * @param GroupUser $groupUser
     * @return JsonResponse
     */
    public function destroy(GroupUser $groupUser): JsonResponse
    {
        $groupUser->delete();
        return response()->json([], 204); // No Content response
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    public function methods(): JsonResponse
    {
        return response()->json([
            'methods' => [
                'GET', 'POST', 'PUT', 'DELETE'
            ]
        ]);
    }
}
