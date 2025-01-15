<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionStoreRequest;
use App\Http\Requests\PermissionUpdateRequest;
use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class PermissionController
 *
 * This controller handles the main operations for permission resource management,
 * including listing, creating, reading, updating, and deleting permissions.
 * It also provides supported HTTP methods for the resource.
 */
class PermissionController extends Controller
{
    /**
     * Display a listing of the permissions.
     *
     * @return PermissionCollection
     */
    public function index(): PermissionCollection
    {
        $permissions = Permission::paginate(request()->input('perPage'));
        return new PermissionCollection($permissions);
    }

    /**
     * Store a newly created permission in storage.
     *
     * @param PermissionStoreRequest $request
     * @return PermissionResource
     */
    public function store(PermissionStoreRequest $request): PermissionResource
    {
        $permission = Permission::create($request->validated());
        return new PermissionResource($permission);
    }

    /**
     * Display the specified permission.
     *
     * @param Permission $permission
     * @return PermissionResource
     */
    public function show(Permission $permission): PermissionResource
    {
        return new PermissionResource($permission);
    }

    /**
     * Update the specified permission in storage.
     *
     * @param PermissionUpdateRequest $request
     * @param Permission $permission
     * @return PermissionResource
     */
    public function update(PermissionUpdateRequest $request, Permission $permission): PermissionResource
    {
        $permission->update($request->validated());
        return new PermissionResource($permission);
    }

    /**
     * Remove the specified permission from storage.
     *
     * @param Permission $permission
     * @return Response
     */
    public function destroy(Permission $permission): Response
    {
        $permission->delete();
        return response()->noContent();
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
