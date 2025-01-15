<?php

namespace App\Http\Controllers;

use App\Http\Requests\PriceGroupStoreRequest;
use App\Http\Requests\PriceGroupUpdateRequest;
use App\Http\Resources\PriceGroupCollection;
use App\Http\Resources\PriceGroupResource;
use App\Models\PriceGroup;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class PriceGroupController
 *
 * This controller handles the main operations for price group resource management,
 * including listing, creating, reading, updating, and deleting price groups.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Price Groups',
    description: 'Operations for managing price groups',
)]
class PriceGroupController extends Controller
{
    /**
     * Display a listing of the price groups.
     *
     * @return PriceGroupCollection
     */
    #[OA\Get(
        path: '/price-groups',
        operationId: 'listPriceGroups',
        description: 'Retrieve a paginated list of price groups',
        summary: 'List price groups',
        security: [],
        tags: ['Price Groups'],
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
                description: 'Successfully retrieved list of price groups',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PriceGroupCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function index(): PriceGroupCollection
    {
        $priceGroups = PriceGroup::paginate(request()->input('perPage'));
        return new PriceGroupCollection($priceGroups);
    }

    /**
     * Store a newly created price group in storage.
     *
     * @param PriceGroupStoreRequest $request
     * @return PriceGroupResource
     */
    #[OA\Post(
        path: '/price-groups',
        operationId: 'createPriceGroup',
        description: 'Create a new price group',
        summary: 'Create a new price group',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PriceGroupStoreRequest')
        ),
        tags: ['Price Groups'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created price group',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PriceGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function store(PriceGroupStoreRequest $request): PriceGroupResource
    {
        $priceGroup = PriceGroup::create($request->validated());
        return new PriceGroupResource($priceGroup);
    }

    /**
     * Display the specified price group.
     *
     * @param PriceGroup $priceGroup
     * @return PriceGroupResource
     */
    #[OA\Get(
        path: '/price-groups/{priceGroup}',
        operationId: 'showPriceGroup',
        description: 'Retrieve details of a specific price group',
        summary: 'Retrieve details of a specific price group',
        tags: ['Price Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'priceGroup',
                description: 'The ID of the price group to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved price group details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PriceGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Price group not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function show(PriceGroup $priceGroup): PriceGroupResource
    {
        return new PriceGroupResource($priceGroup);
    }

    /**
     * Update the specified price group in storage.
     *
     * @param PriceGroupUpdateRequest $request
     * @param PriceGroup $priceGroup
     * @return PriceGroupResource
     */
    #[OA\Put(
        path: '/price-groups/{priceGroup}',
        operationId: 'updatePriceGroup',
        description: 'Update an existing price group',
        summary: 'Update an existing price group',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PriceGroupUpdateRequest')
        ),
        tags: ['Price Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'priceGroup',
                description: 'The ID of the price group to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated price group',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PriceGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Price group not found',
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
            ),
        ]
    )]
    public function update(PriceGroupUpdateRequest $request, PriceGroup $priceGroup): PriceGroupResource
    {
        $priceGroup->update($request->validated());
        return new PriceGroupResource($priceGroup);
    }

    /**
     * Remove the specified price group from storage.
     *
     * @param PriceGroup $priceGroup
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/price-groups/{priceGroup}',
        operationId: 'deletePriceGroup',
        description: 'Delete a specific price group',
        summary: 'Delete a specific price group',
        tags: ['Price Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'priceGroup',
                description: 'The ID of the price group to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted price group',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Price group not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function destroy(PriceGroup $priceGroup): JsonResponse
    {
        $priceGroup->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'price-groups' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/price-groups/methods',
        operationId: 'listMethodsPriceGroups',
        description: 'Retrieve the list of supported HTTP methods for price groups',
        summary: 'List all supported HTTP methods for price groups',
        tags: ['Price Groups'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsPriceGroupsResult',
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
