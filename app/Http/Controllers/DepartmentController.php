<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartmentStoreRequest;
use App\Http\Requests\DepartmentUpdateRequest;
use App\Http\Resources\DepartmentCollection;
use App\Http\Resources\DepartmentResource;
use App\Models\Department;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class DepartmentController
 *
 * This controller handles the main operations for department resource management,
 * including listing, creating, reading, updating, and deleting departments.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Departments',
    description: 'Operations for managing departments',
)]
class DepartmentController extends Controller
{
    /**
     * Display a listing of the departments.
     *
     * @return DepartmentCollection
     */
    #[OA\Get(
        path: '/departments',
        operationId: 'listDepartments',
        description: 'Retrieve a paginated list of departments',
        summary: 'List departments',
        security: [],
        tags: ['Departments'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 5),
                example: 5
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Number of page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: '1'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of departments',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/DepartmentCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): DepartmentCollection
    {
        $departments = Department::paginate(request()->input('perPage'));
        return new DepartmentCollection($departments);
    }

    /**
     * Store a newly created department in storage.
     *
     * @param DepartmentStoreRequest $request
     * @return DepartmentResource
     */
    #[OA\Post(
        path: '/departments',
        operationId: 'updateDepartment',
        description: 'Create a new department',
        summary: 'Create a new department',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/DepartmentStoreRequest')
        ),
        tags: ['Departments'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created department',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/DepartmentResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function store(DepartmentStoreRequest $request): DepartmentResource
    {
        $department = Department::create($request->validated());
        return new DepartmentResource($department);
    }

    /**
     * Display the specified department.
     *
     * @param Department $department
     * @return DepartmentResource
     */
    #[OA\Get(
        path: '/departments/{department}',
        operationId: 'showDepartment',
        description: 'Retrieve details of a specific department',
        summary: 'Retrieve details of a specific department',
        tags: ['Departments'],
        parameters: [
            new OA\PathParameter(
                name: 'department',
                description: 'The ID of the department to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved department details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/DepartmentResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function show(Department $department): DepartmentResource
    {
        return new DepartmentResource($department);
    }

    /**
     * Update the specified department in storage.
     *
     * @param DepartmentUpdateRequest $request
     * @param Department $department
     * @return DepartmentResource
     */
    #[OA\Put(
        path: '/departments/{department}',
        operationId: 'updateDepartments',
        description: 'Update an existing department',
        summary: 'Update an existing department',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/DepartmentUpdateRequest')
        ),
        tags: ['Departments'],
        parameters: [
            new OA\PathParameter(
                name: 'department',
                description: 'The ID of the department to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated department',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/DepartmentResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function update(DepartmentUpdateRequest $request, Department $department): DepartmentResource
    {
        $department->update($request->validated());
        return new DepartmentResource($department);
    }

    /**
     * Remove the specified department from storage.
     *
     * @param Department $department
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/departments/{department}',
        operationId: 'deleteDepartment',
        description: 'Delete a specific department',
        summary: 'Delete a specific department',
        tags: ['Departments'],
        parameters: [
            new OA\PathParameter(
                name: 'department',
                description: 'The ID of the department to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted department',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function destroy(Department $department): JsonResponse
    {
        $department->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'departments' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/departments/methods',
        operationId: 'listMethodsDepartments',
        description: 'Retrieve the list of supported HTTP methods for departments',
        summary: 'List all supported HTTP methods for departments',
        tags: ['Departments'],
        responses: [
            new OA\Response(
                ref: '#/components/responses/Default',
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsDepartmentsResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function methods(): JsonResponse
    {
        return response()->json([
            'methods' => [
                'GET', 'POST', 'PUT', 'DELETE'
            ]
        ]);
    }
}
