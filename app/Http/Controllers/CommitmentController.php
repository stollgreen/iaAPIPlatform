<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitmentStoreRequest;
use App\Http\Requests\CommitmentUpdateRequest;
use App\Http\Resources\CommitmentCollection;
use App\Http\Resources\CommitmentResource;
use App\Models\Commitment;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class CommitmentController
 *
 * This controller handles the main operations for commitment resource management,
 * including listing, creating, reading, updating, and deleting commitments.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Commitments',
    description: 'Operations for managing commitments',
)]
class CommitmentController extends Controller
{
    /**
     * Display a listing of the commitments.
     *
     * @return CommitmentCollection
     */
    #[OA\Get(
        path: '/commitments',
        operationId: 'listCommitments',
        description: 'Retrieve a paginated list of commitments',
        summary: 'List commitments',
        security: [],
        tags: ['Commitments'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 5), // Optional: Standardwert
                example: 15 // Optional: Beispielwert
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Number of page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: '1'), // Optional: Standardwert
                example: 1 // Optional: Beispielwert
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of commitments',
                x: [
                    new OA\JsonContent(
                        ref: '#/components/schemas/CommitmentCollection'
                    ),
                    new OA\Response(
                        ref: '#/components/responses/Default',
                    )
                ]
            )
        ]
    )]
    public function index(): CommitmentCollection
    {
        $commitments = Commitment::paginate(request()->input('perPage'));
        return new CommitmentCollection($commitments);
    }

    /**
     * Store a newly created commitment in storage.
     *
     * @param CommitmentStoreRequest $request
     * @return CommitmentResource
     */
    #[OA\Post(
        path: '/commitments',
        operationId: 'createCommitment',
        description: 'Create a new commitment',
        summary: 'Create a new commitment',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CommitmentStoreRequest')
        ),
        tags: ['Commitments'],
        responses: [
            new OA\Response(
                response: "default",
                description: 'Successfully created commitment',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ],
            ),
        ],

    )]
    public function store(CommitmentStoreRequest $request): CommitmentResource
    {
        $commitment = Commitment::create($request->validated());
        return new CommitmentResource($commitment);
    }

    /**
     * Display the specified commitment.
     *
     * @param Commitment $commitment
     * @return CommitmentResource
     */
    #[OA\Get(
        path: '/commitments/{commitment}',
        operationId: 'showCommitment',
        description: 'Retrieve details of a specific commitment',
        summary: 'Retrieve details of a specific commitment',
        tags: ['Commitments'],
        parameters: [
            new OA\PathParameter(
                name: 'commitment',
                description: 'The ID of the commitment to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved commitment details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
            ),
        ]
    )]
    public function show(Commitment $commitment): CommitmentResource
    {
        return new CommitmentResource($commitment);
    }

    /**
     * Update the specified commitment in storage.
     *
     * @param CommitmentUpdateRequest $request
     * @param Commitment $commitment
     * @return CommitmentResource
     */
    #[OA\Put(
        path: '/commitments/{commitment}',
        operationId: 'updateCommitment',
        description: 'Update an existing commitment',
        summary: 'Update an existing commitment',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CommitmentUpdateRequest')
        ),
        tags: ['Commitments'],
        parameters: [
            new OA\PathParameter(
                name: 'commitment',
                description: 'The ID of the commitment to update',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated commitment',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function update(CommitmentUpdateRequest $request, Commitment $commitment): CommitmentResource
    {
        $commitment->update($request->validated());
        return new CommitmentResource($commitment);
    }

    /**
     * Remove the specified commitment from storage.
     *
     * @param Commitment $commitment
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/commitments/{commitment}',
        operationId: 'deleteCommitment',
        description: 'Delete a specific commitment',
        summary: 'Delete a specific commitment',
        tags: ['Commitments'],
        parameters: [
            new OA\PathParameter(
                name: 'commitment',
                description: 'The ID of the commitment to delete',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted commitment',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Commitment not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(Commitment $commitment): JsonResponse
    {
        $commitment->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'commitments' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/commitments/methods',
        operationId: 'listMethodsCommitments',
        description: 'Retrieve the list of supported HTTP methods for commitments',
        summary: 'List all supported HTTP methods for commitments',
        tags: ['Commitments'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsCommitmentsResult',
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