<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryConditionStoreRequest;
use App\Http\Requests\InventoryConditionUpdateRequest;
use App\Http\Resources\InventoryConditionCollection;
use App\Http\Resources\InventoryConditionResource;
use App\Models\InventoryCondition;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InventoryConditionController
 *
 * This controller handles the main operations for inventory condition resource management,
 * including listing, creating, reading, updating, and deleting inventory conditions.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Inventory Conditions',
    description: 'Operations for managing inventory conditions',
)]
class InventoryConditionController extends Controller
{
    /**
     * Display a listing of the inventory conditions.
     *
     * @return InventoryConditionCollection
     */
    #[OA\Get(
        path: '/inventory-conditions',
        operationId: 'listInventoryConditions',
        description: 'Retrieve a paginated list of inventory conditions',
        summary: 'List inventory conditions',
        security: [],
        tags: ['Inventory Conditions'],
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
                description: 'Successfully retrieved list of inventory conditions',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryConditionCollection'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): InventoryConditionCollection
    {
        $inventoryConditions = InventoryCondition::paginate(request()->input('perPage'));
        return new InventoryConditionCollection($inventoryConditions);
    }

    /**
     * Store a newly created inventory condition in storage.
     *
     * @param InventoryConditionStoreRequest $request
     * @return InventoryConditionResource
     */
    #[OA\Post(
        path: '/inventory-conditions',
        operationId: 'createInventoryCondition',
        description: 'Create a new inventory condition',
        summary: 'Create a new inventory condition',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InventoryConditionStoreRequest')
        ),
        tags: ['Inventory Conditions'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created inventory condition',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryConditionResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function store(InventoryConditionStoreRequest $request): InventoryConditionResource
    {
        $inventoryCondition = InventoryCondition::create($request->validated());
        return new InventoryConditionResource($inventoryCondition);
    }

    /**
     * Display the specified inventory condition.
     *
     * @param InventoryCondition $inventoryCondition
     * @return InventoryConditionResource
     */
    #[OA\Get(
        path: '/inventory-conditions/{inventoryCondition}',
        operationId: 'showInventoryCondition',
        description: 'Retrieve details of a specific inventory condition',
        summary: 'Retrieve a specific inventory condition',
        tags: ['Inventory Conditions'],
        parameters: [
            new OA\PathParameter(
                name: 'inventoryCondition',
                description: 'The ID of the inventory condition to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved inventory condition details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryConditionResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function show(InventoryCondition $inventoryCondition): InventoryConditionResource
    {
        return new InventoryConditionResource($inventoryCondition);
    }

    /**
     * Update the specified inventory condition in storage.
     *
     * @param InventoryConditionUpdateRequest $request
     * @param InventoryCondition $inventoryCondition
     * @return InventoryConditionResource
     */
    #[OA\Put(
        path: '/inventory-conditions/{inventoryCondition}',
        operationId: 'updateInventoryCondition',
        description: 'Update an existing inventory condition',
        summary: 'Update an inventory condition',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InventoryConditionUpdateRequest')
        ),
        tags: ['Inventory Conditions'],
        parameters: [
            new OA\PathParameter(
                name: 'inventoryCondition',
                description: 'The ID of the inventory condition to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated inventory condition',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryConditionResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function update(InventoryConditionUpdateRequest $request, InventoryCondition $inventoryCondition): InventoryConditionResource
    {
        $inventoryCondition->update($request->validated());
        return new InventoryConditionResource($inventoryCondition);
    }

    /**
     * Remove the specified inventory condition from storage.
     *
     * @param InventoryCondition $inventoryCondition
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/inventory-conditions/{inventoryCondition}',
        operationId: 'deleteInventoryCondition',
        description: 'Delete a specific inventory condition',
        summary: 'Delete an inventory condition',
        tags: ['Inventory Conditions'],
        parameters: [
            new OA\PathParameter(
                name: 'inventoryCondition',
                description: 'The ID of the inventory condition to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted inventory condition',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Inventory condition not found',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(InventoryCondition $inventoryCondition): JsonResponse
    {
        $inventoryCondition->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return supported HTTP methods for the inventory conditions resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/inventory-conditions/methods',
        operationId: 'listMethodsInventoryConditions',
        description: 'Retrieve the list of supported HTTP methods for inventory conditions',
        summary: 'List supported HTTP methods for inventory conditions',
        tags: ['Inventory Conditions'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsInventoryConditionsResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
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
