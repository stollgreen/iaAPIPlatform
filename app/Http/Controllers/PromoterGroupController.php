<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoterGroupStoreRequest;
use App\Http\Requests\PromoterGroupUpdateRequest;
use App\Http\Resources\PromoterCollection;
use App\Http\Resources\PromoterGroupCollection;
use App\Http\Resources\PromoterGroupResource;
use App\Models\Promoter;
use App\Models\PromoterGroup;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class PromoterGroupController
 *
 * This controller handles the main operations for promoter group resource management,
 * including listing, creating, reading, updating, and deleting groups.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Promoter Groups',
    description: 'Operations for managing promoter groups',
)]
class PromoterGroupController extends Controller
{
    /**
     * Display a listing of the promoter groups.
     *
     * @return PromoterGroupCollection
     */
    #[OA\Get(
        path: '/promoter-groups',
        operationId: 'listPromoterGroups',
        description: 'Retrieve a paginated list of promoter groups',
        summary: 'List promoter groups',
        security: [],
        tags: ['Promoter Groups'],
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
                description: 'Successfully retrieved list of promoter groups',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterGroupCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): PromoterGroupCollection
    {
        $promoterGroups = PromoterGroup::paginate(request()->input('perPage'));
        return new PromoterGroupCollection($promoterGroups);
    }

    /**
     * Store a newly created promoter group in storage.
     *
     * @param PromoterGroupStoreRequest $request
     * @return PromoterGroupResource
     */
    #[OA\Post(
        path: '/promoter-groups',
        operationId: 'createPromoterGroup',
        description: 'Create a new promoter group',
        summary: 'Create a new promoter group',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PromoterGroupStoreRequest')
        ),
        tags: ['Promoter Groups'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created promoter group',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'The specified promoter group does not exist',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function store(PromoterGroupStoreRequest $request): PromoterGroupResource
    {
        $promoterGroup = PromoterGroup::create($request->validated());
        return new PromoterGroupResource($promoterGroup);
    }

    /**
     * Display the specified promoter group.
     *
     * @param PromoterGroup $promoterGroup
     * @return PromoterGroupResource
     */
    #[OA\Get(
        path: '/promoter-groups/{promoterGroup}',
        operationId: 'showPromoterGroup',
        description: 'Retrieve details of a specific promoter group',
        summary: 'Retrieve details of a specific promoter group',
        tags: ['Promoter Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'promoterGroup',
                description: 'The ID of the promoter group to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved promoter group details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'The specified promoter group does not exist',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(PromoterGroup $promoterGroup): PromoterGroupResource
    {
        return new PromoterGroupResource($promoterGroup);
    }

    /**
     * Retrieve all members of a promoter group
     */
    #[OA\Get(
        path: '/promoter-groups/{promoterGroup}/members',
        operationId: 'listPromoterGroupMembers',
        description: 'Retrieve a list of all members of a promoter group',
        summary: 'List members of a promoter group',
        tags: ['Promoter Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'promoterGroup',
                description: 'The ID of the promoter group to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', default: 1)
            ),
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 5)
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Number of page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1), // Optional: Standardwert
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of members of a promoter group',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
            ),
            new OA\Response(
                response: 404,
                description: 'The specified promoter group does not exist',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function members(PromoterGroup $promoter_group_id): PromoterCollection {
        return new PromoterCollection(Promoter::where('promoter_group_id', $promoter_group_id->id)->get());
    }

    /**
     * Update the specified promoter group in storage.
     *
     * @param PromoterGroupUpdateRequest $request
     * @param PromoterGroup $promoterGroup
     * @return PromoterGroupResource
     */
    #[OA\Put(
        path: '/promoter-groups/{promoterGroup}',
        operationId: 'updatePromoterGroup',
        description: 'Update an existing promoter group',
        summary: 'Update an existing promoter group',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PromoterGroupUpdateRequest')
        ),
        tags: ['Promoter Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'promoterGroup',
                description: 'The ID of the promoter group to update',
                required: true,
                schema: new OA\Schema(type: 'integer', default: 1)
            )],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated promoter group',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PromoterGroupResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'The specified promoter group does not exist',
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
    public function update(PromoterGroupUpdateRequest $request, PromoterGroup $promoterGroup): PromoterGroupResource
    {
        $promoterGroup->update($request->validated());
        return new PromoterGroupResource($promoterGroup);
    }

    /**
     * Remove the specified promoter group from storage.
     *
     * @param PromoterGroup $promoterGroup
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/promoter-groups/{promoterGroup}',
        operationId: 'destroyPromoterGroup',
        description: 'Delete a specific promoter group',
        summary: 'Delete a specific promoter group',
        tags: ['Promoter Groups'],
        parameters: [
            new OA\PathParameter(
                name: 'promoterGroup',
                description: 'The ID of the promoter group to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted promoter group',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'The specified promoter group does not exist',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(PromoterGroup $promoterGroup): JsonResponse
    {
        $promoterGroup->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'promoter groups' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/promoter-groups/methods',
        operationId: 'listMethodsPromoterGroups',
        description: 'Retrieve the list of supported HTTP methods for promoter groups',
        summary: 'List all supported HTTP methods for promoter groups',
        tags: ['Promoter Groups'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsPromoterGroupsResult',
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

