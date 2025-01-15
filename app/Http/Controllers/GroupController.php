<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Resources\GroupCollection;
use App\Http\Resources\GroupResource;
use App\Models\Group;
use Illuminate\Http\JsonResponse;


/**
 * Class GroupController
 *
 * This controller handles the main operations for group resource management,
 * including listing, creating, reading, updating, and deleting groups.
 * It also provides supported HTTP methods for the resource.
 */
class GroupController extends Controller
{
    /**
     * Display a listing of the groups.
     *
     * @return GroupCollection
     */
    public function index(): GroupCollection
    {
        $groups = Group::paginate(request()->input('perPage'));
        return new GroupCollection($groups);
    }

    /**
     * Store a newly created group in storage.
     *
     * @param GroupStoreRequest $request
     * @return GroupResource
     */
    public function store(GroupStoreRequest $request): GroupResource
    {
        $group = Group::create($request->validated());
        return new GroupResource($group);
    }

    /**
     * Display the specified group.
     *
     * @param Group $group
     * @return GroupResource
     */
    public function show(Group $group): GroupResource
    {
        return new GroupResource($group);
    }

    /**
     * Update the specified group in storage.
     *
     * @param GroupUpdateRequest $request
     * @param Group $group
     * @return GroupResource
     */
    public function update(GroupUpdateRequest $request, Group $group): GroupResource
    {
        $group->update($request->validated());
        return new GroupResource($group);
    }

    /**
     * Remove the specified group from storage.
     *
     * @param Group $group
     * @return JsonResponse
     */
    public function destroy(Group $group): JsonResponse
    {
        $group->delete();
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
