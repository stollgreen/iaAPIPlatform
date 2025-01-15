<?php

namespace App\Http\Controllers;

use App\Http\Requests\GenderStoreRequest;
use App\Http\Requests\GenderUpdateRequest;
use App\Http\Resources\GenderCollection;
use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class GenderController
 *
 * This controller handles the main operations for gender resource management,
 * including listing, creating, reading, updating, and deleting genders.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Genders',
    description: 'Operations for managing genders',
)]
class GenderController extends Controller
{
    /**
     * Display a listing of the genders.
     *
     * @return GenderCollection
     */
    #[OA\Get(
        path: '/genders',
        operationId: 'listGenders',
        description: 'Retrieve a paginated list of genders',
        summary: 'List genders',
        security: [],
        tags: ['Genders'],
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
                description: 'Successfully retrieved list of genders',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/GenderCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): GenderCollection
    {
        $genders = Gender::paginate(request()->input('perPage'));
        return new GenderCollection($genders);
    }

    /**
     * Store a newly created gender in storage.
     *
     * @param GenderStoreRequest $request
     * @return GenderResource
     */
    #[OA\Post(
        path: '/genders',
        operationId: 'createGender',
        description: 'Create a new gender',
        summary: 'Create a new gender',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GenderStoreRequest')
        ),
        tags: ['Genders'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created gender',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/GenderResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function store(GenderStoreRequest $request): GenderResource
    {
        $gender = Gender::create($request->validated());
        return new GenderResource($gender);
    }

    /**
     * Display the specified gender.
     *
     * @param Gender $gender
     * @return GenderResource
     */
    #[OA\Get(
        path: '/genders/{gender}',
        operationId: 'showGender',
        description: 'Retrieve details of a specific gender',
        summary: 'Retrieve details of a specific gender',
        tags: ['Genders'],
        parameters: [
            new OA\PathParameter(
                name: 'gender',
                description: 'The ID of the gender to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved gender details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/GenderResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function show(Gender $gender): GenderResource
    {
        return new GenderResource($gender);
    }

    /**
     * Update the specified gender in storage.
     *
     * @param GenderUpdateRequest $request
     * @param Gender $gender
     * @return GenderResource
     */
    #[OA\Put(
        path: '/genders/{gender}',
        operationId: 'updateGender',
        description: 'Update an existing gender',
        summary: 'Update an existing gender',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/GenderUpdateRequest')
        ),
        tags: ['Genders'],
        parameters: [
            new OA\PathParameter(
                name: 'gender',
                description: 'The ID of the gender to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated gender',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/GenderResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function update(GenderUpdateRequest $request, Gender $gender): GenderResource
    {
        $gender->update($request->validated());
        return new GenderResource($gender);
    }

    /**
     * Remove the specified gender from storage.
     *
     * @param Gender $gender
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/genders/{gender}',
        operationId: 'deleteGender',
        description: 'Delete a specific gender',
        summary: 'Delete a specific gender',
        tags: ['Genders'],
        parameters: [
            new OA\PathParameter(
                name: 'gender',
                description: 'The ID of the gender to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted gender',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function destroy(Gender $gender): JsonResponse
    {
        $gender->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'genders' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/genders/methods',
        operationId: 'listMethodsGenders',
        description: 'Retrieve the list of supported HTTP methods for genders',
        summary: 'List all supported HTTP methods for genders',
        tags: ['Genders'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsGendersResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
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
