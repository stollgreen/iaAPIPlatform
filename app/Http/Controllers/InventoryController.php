<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryStoreRequest;
use App\Http\Requests\InventoryUpdateRequest;
use App\Http\Resources\InventoryCollection;
use App\Http\Resources\InventoryResource;
use App\Models\Inventory;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class InventoryController
 *
 * This controller handles the main operations for inventory resource management,
 * including listing, creating, reading, updating, and deleting inventories.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Inventories',
    description: 'Operations for managing inventories',
)]
class InventoryController extends Controller
{
    /**
     * Display a listing of the inventories.
     *
     * @return InventoryCollection
     */
    #[OA\Get(
        path: '/inventories',
        operationId: 'listInventories',
        description: 'Retrieve a paginated list of inventories',
        summary: 'List inventories',
        tags: ['Inventories'],
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
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of inventories',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): InventoryCollection
    {
        $inventories = Inventory::paginate(request()->input('perPage'));
        return new InventoryCollection($inventories);
    }

    /**
     * Store a newly created inventory in storage.
     *
     * @param InventoryStoreRequest $request
     * @return InventoryResource
     */
    #[OA\Post(
        path: '/inventories',
        operationId: 'createInventory',
        description: 'Create a new inventory',
        summary: 'Create a new inventory',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InventoryStoreRequest')
        ),
        tags: ['Inventories'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created inventory',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
            )
        ]
    )]
    public function store(InventoryStoreRequest $request): InventoryResource
    {
        $inventory = Inventory::create($request->validated());
        return new InventoryResource($inventory);
    }

    /**
     * Display the specified inventory.
     *
     * @param Inventory $inventory
     * @return InventoryResource
     */
    #[OA\Get(
        path: '/inventories/{inventory}',
        operationId: 'showInventory',
        description: 'Retrieve details of a specific inventory',
        summary: 'Retrieve details of a specific inventory',
        tags: ['Inventories'],
        parameters: [
            new OA\PathParameter(
                name: 'inventory',
                description: 'The ID of the inventory to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved inventory details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Inventory not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(Inventory $inventory): InventoryResource
    {
        return new InventoryResource($inventory);
    }

    /**
     * Update the specified inventory in storage.
     *
     * @param InventoryUpdateRequest $request
     * @param Inventory $inventory
     * @return InventoryResource
     */
    #[OA\Put(
        path: '/inventories/{inventory}',
        operationId: 'updateInventory',
        description: 'Update an existing inventory',
        summary: 'Update an existing inventory',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InventoryUpdateRequest')
        ),
        tags: ['Inventories'],
        parameters: [
            new OA\PathParameter(
                name: 'inventory',
                description: 'The ID of the inventory to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated inventory',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InventoryResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Inventory not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )

        ]
    )]
    public function update(InventoryUpdateRequest $request, Inventory $inventory): InventoryResource
    {
        $inventory->update($request->validated());
        return new InventoryResource($inventory);
    }

    /**
     * Remove the specified inventory from storage.
     *
     * @param Inventory $inventory
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/inventories/{inventory}',
        operationId: 'deleteInventory',
        description: 'Delete a specific inventory',
        summary: 'Delete a specific inventory',
        tags: ['Inventories'],
        parameters: [
            new OA\PathParameter(
                name: 'inventory',
                description: 'The ID of the inventory to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted inventory',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Inventory not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(Inventory $inventory): JsonResponse
    {
        $inventory->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'inventories' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/inventories/methods',
        operationId: 'listMethodsInventory',
        description: 'Retrieve the list of supported HTTP methods for inventories',
        summary: 'List all supported HTTP methods for inventories',
        tags: ['Inventories'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsInventory',
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
