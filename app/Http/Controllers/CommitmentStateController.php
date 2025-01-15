<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommitmentStateStoreRequest;
use App\Http\Requests\CommitmentStateUpdateRequest;
use App\Http\Resources\CommitmentStateCollection;
use App\Http\Resources\CommitmentStateResource;
use App\Models\CommitmentState;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class CommitmentStateController
 *
 * This controller handles the operations for commitment state resource management,
 * including listing, creating, reading, updating, and deleting commitment states.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'CommitmentStates',
    description: 'Operations for managing commitment states'
)]
class CommitmentStateController extends Controller
{
    /**
     * Display a listing of the commitment states.
     *
     * @return CommitmentStateCollection
     */
    #[OA\Get(
        path: '/commitment-states',
        operationId: 'listCommitmentStates',
        description: 'Retrieve a paginated list of commitment states',
        summary: 'List commitment states',
        tags: ['Commitment States'],
        parameters: [
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
                example: 1 // Optional: Beispielwert
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of commitment states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentStateCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): CommitmentStateCollection
    {
        $commitmentStates = CommitmentState::paginate(request()->input('perPage'));
        return new CommitmentStateCollection($commitmentStates);
    }

    /**
     * Store a newly created commitment state in storage.
     *
     * @param CommitmentStateStoreRequest $request
     * @return CommitmentStateResource
     */
    #[OA\Post(
        path: '/commitment-states',
        operationId: 'createCommitmentState',
        summary: 'Create a new commitment state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CommitmentStateStoreRequest')
        ),
        tags: ['Commitment States'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created commitment state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                    new OA\JsonContent(
                        title: 'CommitmentStateStoreRequestValidationErrors',
                        properties: [
                            new OA\Property(property: 'message', type: 'string'),
                            new OA\Property(property: 'errors', type: 'object', example: ['name' => ['The name field is required.']])
                        ]
                    )
                ]
            )
        ]
    )]
    public function store(CommitmentStateStoreRequest $request): CommitmentStateResource
    {
        $commitmentState = CommitmentState::create($request->validated());
        return new CommitmentStateResource($commitmentState);
    }

    /**
     * Display the specified commitment state.
     *
     * @param CommitmentState $commitmentState
     * @return CommitmentStateResource
     */
    #[OA\Get(
        path: '/commitment-states/{commitmentState}',
        operationId: 'showCommitmentState',
        summary: 'Retrieve details of a specific commitment state',
        tags: ['Commitment States'],
        parameters: [
            new OA\PathParameter(
                name: 'commitmentState',
                description: 'The ID of the commitment state to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                ref: '#/components/responses/Default',
                response: 200,
                description: 'Successfully retrieved commitment state details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Commitment state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(CommitmentState $commitmentState): CommitmentStateResource
    {
        return new CommitmentStateResource($commitmentState);
    }

    /**
     * Update the specified commitment state in storage.
     *
     * @param CommitmentStateUpdateRequest $request
     * @param CommitmentState $commitmentState
     * @return CommitmentStateResource
     */
    #[OA\Put(
        path: '/commitment-states/{commitmentState}',
        operationId: 'updateCommitmentState',
        summary: 'Update an existing commitment state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CommitmentStateUpdateRequest')
        ),
        tags: ['Commitment States'],
        parameters: [
            new OA\PathParameter(
                name: 'commitmentState',
                description: 'The ID of the commitment state to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated commitment state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CommitmentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Commitment state not found',
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
    public function update(CommitmentStateUpdateRequest $request, CommitmentState $commitmentState): CommitmentStateResource
    {
        $commitmentState->update($request->validated());
        return new CommitmentStateResource($commitmentState);
    }

    /**
     * Remove the specified commitment state from storage.
     *
     * @param CommitmentState $commitmentState
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/commitment-states/{commitmentState}',
        operationId: 'deleteCommitmentState',
        summary: 'Delete a specific commitment state',
        tags: ['Commitment States'],
        parameters: [
            new OA\PathParameter(
                name: 'commitmentState',
                description: 'The ID of the commitment state to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                ref: '#/components/responses/Default',
                response: 204,
                description: 'Successfully deleted commitment state'
            ),
            new OA\Response(
                response: 404,
                description: 'Commitment state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(CommitmentState $commitmentState): JsonResponse
    {
        $commitmentState->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/commitment-states/methods',
        operationId: 'listMethodsCommitmentStates',
        summary: 'Retrieve the list of supported HTTP methods for commitment states',
        tags: ['Commitment States'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsCommitmentStatesMethods',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'))
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
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
