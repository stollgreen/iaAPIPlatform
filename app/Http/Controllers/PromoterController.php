<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoterStoreRequest;
use App\Http\Requests\PromoterUpdateRequest;
use App\Http\Resources\PromoterCollection;
use App\Http\Resources\PromoterResource;
use App\Models\Promoter;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class PromoterController
 *
 * This controller handles the main operations for promoter resource management,
 * including listing, creating, reading, updating, and deleting promoters.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Promoters',
    description: 'Operations for managing promoters',
)]
class PromoterController extends Controller
{
    /**
     * Display a listing of the promoters.
     *
     * @return PromoterCollection
     */
    #[OA\Get(
        path: '/promoters',
        operationId: 'listPromoters',
        description: 'Retrieve a paginated list of promoters',
        summary: 'List promoters',
        security: [],
        tags: ['Promoters'],
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
                description: 'Successfully retrieved list of promoters',
                x: [
                    new OA\JsonContent( ref: '#/components/schemas/PromoterCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): PromoterCollection
    {
        $promoters = Promoter::paginate(request()->input('perPage'));
        return new PromoterCollection($promoters);
    }

    /**
     * Store a newly created promoter in storage.
     *
     * @param PromoterStoreRequest $request
     * @return PromoterResource
     */
    #[OA\Post(
        path: '/promoters',
        operationId: 'createPromoter',
        description: 'Create a new promoter',
        summary: 'Create a new promoter',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PromoterStoreRequest')
        ),
        tags: ['Promoters'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created promoter',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function store(PromoterStoreRequest $request): PromoterResource
    {
        $promoter = Promoter::create($request->validated());
        return new PromoterResource($promoter);
    }

    /**
     * Display the specified promoter.
     *
     * @param Promoter $promoter
     * @return PromoterResource
     */
    #[OA\Get(
        path: '/promoters/{promoter}',
        operationId: 'showPromoter',
        description: 'Retrieve details of a specific promoter',
        summary: 'Retrieve details of a specific promoter',
        tags: ['Promoters'],
        parameters: [
            new OA\PathParameter(
                name: 'promoter',
                description: 'The ID of the promoter to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved promoter details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Promoter not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Promoter $promoter): PromoterResource
    {
        return new PromoterResource($promoter);
    }

    /**
     * Update the specified promoter in storage.
     *
     * @param PromoterUpdateRequest $request
     * @param Promoter $promoter
     * @return PromoterResource
     */
    #[OA\Put(
        path: '/promoters/{promoter}',
        operationId: 'updatePromoter',
        description: 'Update an existing promoter',
        summary: 'Update an existing promoter',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PromoterUpdateRequest')
        ),
        tags: ['Promoters'],
        parameters: [
            new OA\PathParameter(
                name: 'promoter',
                description: 'The ID of the promoter to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated promoter',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Promoter not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function update(PromoterUpdateRequest $request, Promoter $promoter): PromoterResource
    {
        $promoter->update($request->validated());
        return new PromoterResource($promoter);
    }

    /**
     * Remove the specified promoter from storage.
     *
     * @param Promoter $promoter
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/promoters/{promoter}',
        operationId: 'deletePromoter',
        description: 'Delete a specific promoter',
        summary: 'Delete a specific promoter',
        tags: ['Promoters'],
        parameters: [
            new OA\PathParameter(
                name: 'promoter',
                description: 'The ID of the promoter to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted promoter',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Promoter not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(Promoter $promoter): JsonResponse
    {
        $promoter->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'promoters' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/promoters/methods',
        operationId: 'listMethodsPromoters',
        description: 'Retrieve the list of supported HTTP methods for promoters',
        summary: 'List all supported HTTP methods for promoters',
        tags: ['Promoters'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsPromotersResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default')
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
