<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeStoreRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class EmployeeController
 *
 * This controller handles the main operations for employee resource management,
 * including listing, creating, reading, updating, and deleting employees.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Employees',
    description: 'Operations for managing employees',
)]
class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     *
     * @return EmployeeCollection
     */
    #[OA\Get(
        path: '/employees',
        operationId: 'listEmployees',
        description: 'Retrieve a paginated list of employees',
        summary: 'List employees',
        security: [],
        tags: ['Employees'],
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
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of employees',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EmployeeCollection', title: 'listEmployeesResult'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): EmployeeCollection
    {
        $employees = Employee::paginate(request()->input('perPage'));
        return new EmployeeCollection($employees);
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param EmployeeStoreRequest $request
     * @return EmployeeResource
     */
    #[OA\Post(
        path: '/employees',
        operationId: 'createEmployee',
        description: 'Create a new employee',
        summary: 'Create a new employee',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EmployeeStoreRequest')
        ),
        tags: ['Employees'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created employee',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EmployeeResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function store(EmployeeStoreRequest $request): EmployeeResource
    {
        $employee = Employee::create($request->validated());
        return new EmployeeResource($employee);
    }

    /**
     * Display the specified employee.
     *
     * @param Employee $employee
     * @return EmployeeResource
     */
    #[OA\Get(
        path: '/employees/{employee}',
        operationId: 'showEmployee',
        description: 'Retrieve details of a specific employee',
        summary: 'Retrieve details of a specific employee',
        tags: ['Employees'],
        parameters: [
            new OA\PathParameter(
                name: 'employee',
                description: 'The ID of the employee to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved employee details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EmployeeResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function show(Employee $employee): EmployeeResource
    {
        return new EmployeeResource($employee);
    }

    /**
     * Update the specified employee in storage.
     *
     * @param EmployeeUpdateRequest $request
     * @param Employee $employee
     * @return EmployeeResource
     */
    #[OA\Put(
        path: '/employees/{employee}',
        operationId: 'updateEmployee',
        description: 'Update an existing employee',
        summary: 'Update an existing employee',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EmployeeUpdateRequest')
        ),
        tags: ['Employees'],
        parameters: [
            new OA\PathParameter(
                name: 'employee',
                description: 'The ID of the employee to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated employee',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EmployeeResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function update(EmployeeUpdateRequest $request, Employee $employee): EmployeeResource
    {
        $employee->update($request->validated());
        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param Employee $employee
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/employees/{employee}',
        operationId: 'deleteEmployee',
        description: 'Delete a specific employee',
        summary: 'Delete a specific employee',
        tags: ['Employees'],
        parameters: [
            new OA\PathParameter(
                name: 'employee',
                description: 'The ID of the employee to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted employee',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function destroy(Employee $employee): JsonResponse
    {
        $employee->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'employees' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/employees/methods',
        operationId: 'listMethodsEmployees',
        description: 'Retrieve the list of supported HTTP methods for employees',
        summary: 'List all supported HTTP methods for employees',
        tags: ['Employees'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsEmployeesResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default'),
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
