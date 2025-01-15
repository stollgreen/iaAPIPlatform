<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupPermissionStoreRequest;
use App\Http\Requests\GroupPermissionUpdateRequest;
use App\Http\Resources\GroupPermissionCollection;
use App\Http\Resources\GroupPermissionResource;
use App\Models\GroupPermission;
use Illuminate\Http\JsonResponse;

/**
 * Class GroupPermissionController
 *
 * This controller handles the main operations for managing group permissions,
 * including listing, creating, reading, updating, and deleting group permissions.
 * It also provides supported HTTP methods for the resource.
 */
class GroupPermissionController extends Controller
{
    /**
     * Display a listing of the group permissions.
     *
     * @return GroupPermissionCollection
     */
    public function index(): GroupPermissionCollection
    {
        $groupPermissions = GroupPermission::paginate(request()->input('perPage'));
        return new GroupPermissionCollection($groupPermissions);
    }

    /**
     * Store a newly created group permission in storage.
     *
     * @param GroupPermissionStoreRequest $request
     * @return GroupPermissionResource
     */
    public function store(GroupPermissionStoreRequest $request): GroupPermissionResource
    {
        $groupPermission = GroupPermission::create($request->validated());
        return new GroupPermissionResource($groupPermission);
    }

    /**
     * Display the specified group permission.
     *
     * @param GroupPermission $groupPermission
     * @return GroupPermissionResource
     */
    public function show(GroupPermission $groupPermission): GroupPermissionResource
    {
        return new GroupPermissionResource($groupPermission);
    }

    /**
     * Update the specified group permission in storage.
     *
     * @param GroupPermissionUpdateRequest $request
     * @param GroupPermission $groupPermission
     * @return GroupPermissionResource
     */
    public function update(GroupPermissionUpdateRequest $request, GroupPermission $groupPermission): GroupPermissionResource
    {
        $groupPermission->update($request->validated());
        return new GroupPermissionResource($groupPermission);
    }

    /**
     * Remove the specified group permission from storage.
     *
     * @param GroupPermission $groupPermission
     * @return JsonResponse
     */
    public function destroy(GroupPermission $groupPermission): JsonResponse
    {
        $groupPermission->delete();
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
