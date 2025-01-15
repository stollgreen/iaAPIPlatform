<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerStoreRequest;
use App\Http\Requests\CustomerUpdateRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class CustomerController
 *
 * This controller handles the main operations for customer resource management,
 * including listing, creating, reading, updating, and deleting customers.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Customers',
    description: 'Operations for managing customers'
)]
class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @return CustomerCollection
     */
    #[OA\Get(
        path: '/customers',
        operationId: 'listCustomers',
        description: 'Retrieve a paginated list of customers',
        summary: 'List customers',
        security: [],
        tags: ['Customers'],
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
                description: 'The page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'List of customers retrieved successfully',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CustomerCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): CustomerCollection
    {
        $customers = Customer::paginate(request()->input('perPage'));
        return new CustomerCollection($customers);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param CustomerStoreRequest $request
     * @return CustomerResource
     */
    #[OA\Post(
        path: '/customers',
        operationId: 'createCustomer',
        description: 'Create a new customer',
        summary: 'Create customer',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CustomerStoreRequest')
        ),
        tags: ['Customers'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Customer successfully created',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CustomerResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]

            ),
        ]
    )]
    public function store(CustomerStoreRequest $request): CustomerResource
    {
        $customer = Customer::create($request->validated());
        return new CustomerResource($customer);
    }

    /**
     * Display the specified customer.
     *
     * @param Customer $customer
     * @return CustomerResource
     */
    #[OA\Get(
        path: '/customers/{customer}',
        operationId: 'showCustomer',
        description: 'Retrieve details of a specific customer',
        summary: 'Retrieve customer details',
        tags: ['Customers'],
        parameters: [
            new OA\PathParameter(
                name: 'customer',
                description: 'The ID of the customer to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Customer details retrieved successfully',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CustomerResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function show(Customer $customer): CustomerResource
    {
        return new CustomerResource($customer);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param CustomerUpdateRequest $request
     * @param Customer $customer
     * @return CustomerResource
     */
    #[OA\Put(
        path: '/customers/{customer}',
        operationId: 'updateCustomer',
        description: 'Update an existing customer',
        summary: 'Update customer',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CustomerUpdateRequest')
        ),
        tags: ['Customers'],
        parameters: [
            new OA\PathParameter(
                name: 'customer',
                description: 'The ID of the customer to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Customer successfully updated',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CustomerResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function update(CustomerUpdateRequest $request, Customer $customer): CustomerResource
    {
        $customer->update($request->validated());
        return new CustomerResource($customer);
    }

    /**
     * Remove the specified customer from storage.
     *
     * @param Customer $customer
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/customers/{customer}',
        operationId: 'deleteCustomer',
        description: 'Delete a specific customer',
        summary: 'Delete customer',
        tags: ['Customers'],
        parameters: [
            new OA\PathParameter(
                name: 'customer',
                description: 'The ID of the customer to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Customer successfully deleted',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]

            )
        ]
    )]
    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'customers' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/customers/methods',
        operationId: 'listMethodsCustomers',
        description: 'Retrieve a list of supported HTTP methods for customers',
        summary: 'Retrieve supported HTTP methods for customers',
        tags: ['Customers'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Supported methods retrieved successfully',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsCustomersResult',
                        properties: [
                            new OA\Property(
                                property: 'methods',
                                type: 'array',
                                items: new OA\Items(type: 'string'),
                                example: ['GET', 'POST', 'PUT', 'DELETE']
                            )
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
