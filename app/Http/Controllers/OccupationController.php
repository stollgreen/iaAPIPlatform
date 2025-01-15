<?php

namespace App\Http\Controllers;

use App\Http\Requests\OccupationStoreRequest;
use App\Http\Requests\OccupationUpdateRequest;
use App\Http\Resources\OccupationCollection;
use App\Http\Resources\OccupationResource;
use App\Models\Occupation;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class OccupationController
 *
 * This controller handles the main operations for occupation resource management,
 * including listing, creating, reading, updating, and deleting occupations.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Occupations',
    description: 'Operations for managing occupations',
)]
class OccupationController extends Controller
{
    /**
     * Display a listing of the occupations.
     *
     * @return OccupationCollection
     */
    #[OA\Get(
        path: '/occupations',
        operationId: 'listOccupations',
        description: 'Retrieve a paginated list of occupations',
        summary: 'List occupations',
        security: [],
        tags: ['Occupations'],
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
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: '1'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of occupations',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OccupationCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): OccupationCollection
    {
        $occupations = Occupation::paginate(request()->input('perPage'));
        return new OccupationCollection($occupations);
    }

    /**
     * Store a newly created occupation in storage.
     *
     * @param OccupationStoreRequest $request
     * @return OccupationResource
     */
    #[OA\Post(
        path: '/occupations',
        operationId: 'createOccupation',
        description: 'Create a new occupation',
        summary: 'Create a new occupation',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OccupationStoreRequest')
        ),
        tags: ['Occupations'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created occupation',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OccupationResource'),
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
    public function store(OccupationStoreRequest $request): OccupationResource
    {
        $occupation = Occupation::create($request->validated());
        return new OccupationResource($occupation);
    }

    /**
     * Display the specified occupation.
     *
     * @param Occupation $occupation
     * @return OccupationResource
     */
    #[OA\Get(
        path: '/occupations/{occupation}',
        operationId: 'showOccupation',
        description: 'Retrieve details of a specific occupation',
        summary: 'Retrieve details of a specific occupation',
        tags: ['Occupations'],
        parameters: [
            new OA\PathParameter(
                name: 'occupation',
                description: 'The ID of the occupation to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved occupation details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OccupationResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Occupation not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Occupation $occupation): OccupationResource
    {
        return new OccupationResource($occupation);
    }

    /**
     * Update the specified occupation in storage.
     *
     * @param OccupationUpdateRequest $request
     * @param Occupation $occupation
     * @return OccupationResource
     */
    #[OA\Put(
        path: '/occupations/{occupation}',
        operationId: 'updateOccupation',
        description: 'Update an existing occupation',
        summary: 'Update an existing occupation',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OccupationUpdateRequest')
        ),
        tags: ['Occupations'],
        parameters: [
            new OA\PathParameter(
                name: 'occupation',
                description: 'The ID of the occupation to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated occupation',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OccupationResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Occupation not found',
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
    public function update(OccupationUpdateRequest $request, Occupation $occupation): OccupationResource
    {
        $occupation->update($request->validated());
        return new OccupationResource($occupation);
    }

    /**
     * Remove the specified occupation from storage.
     *
     * @param Occupation $occupation
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/occupations/{occupation}',
        operationId: 'deleteOccupation',
        description: 'Delete a specific occupation',
        summary: 'Delete a specific occupation',
        tags: ['Occupations'],
        parameters: [
            new OA\PathParameter(
                name: 'occupation',
                description: 'The ID of the occupation to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted occupation',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Occupation not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function destroy(Occupation $occupation): JsonResponse
    {
        $occupation->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'occupations' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/occupations/methods',
        operationId: 'listMethodsOccupations',
        description: 'Retrieve the list of supported HTTP methods for occupations',
        summary: 'List all supported HTTP methods for occupations',
        tags: ['Occupations'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsOccupationsResult',
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
