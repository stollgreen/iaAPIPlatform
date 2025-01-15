<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTrackingStateStoreRequest;
use App\Http\Requests\TimeTrackingStateUpdateRequest;
use App\Http\Resources\TimeTrackingStateCollection;
use App\Http\Resources\TimeTrackingStateResource;
use App\Models\TimeTrackingState;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class TimeTrackingStateController
 *
 * Controller for managing time tracking states, providing CRUD operations and supported HTTP methods.
 */
#[OA\Tag(
    name: 'TimeTrackingStates',
    description: 'Operations for managing time tracking states.',
)]
class TimeTrackingStateController extends Controller
{
    /**
     * Display a listing of the time tracking states.
     *
     * @return TimeTrackingStateCollection
     */
    #[OA\Get(
        path: '/time-tracking-states',
        operationId: 'listTimeTrackingStates',
        description: 'Retrieve a paginated list of time tracking states',
        summary: 'List time tracking states',
        tags: ['TimeTrackingStates'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 10),
                example: 10
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Number of the page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of time tracking states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): TimeTrackingStateCollection
    {
        $timeTrackingStates = TimeTrackingState::paginate(request()->query('perPage', 10));
        return new TimeTrackingStateCollection($timeTrackingStates);
    }

    /**
     * Store a newly created time tracking state in storage.
     *
     * @param TimeTrackingStateStoreRequest $request
     * @return TimeTrackingStateResource
     */
    #[OA\Post(
        path: '/time-tracking-states',
        operationId: 'createTimeTrackingState',
        description: 'Create a new time tracking state',
        summary: 'Create time tracking state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateStoreRequest')
        ),
        tags: ['TimeTrackingStates'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created time tracking state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateResource'),
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
    public function store(TimeTrackingStateStoreRequest $request): TimeTrackingStateResource
    {
        $timeTrackingState = TimeTrackingState::create($request->validated());
        return new TimeTrackingStateResource($timeTrackingState);
    }

    /**
     * Display the specified time tracking state.
     *
     * @param TimeTrackingState $timeTrackingState
     * @return TimeTrackingStateResource
     */
    #[OA\Get(
        path: '/time-tracking-states/{timeTrackingState}',
        operationId: 'showTimeTrackingState',
        description: 'Retrieve details of a specific time tracking state',
        summary: 'Retrieve time tracking state',
        tags: ['TimeTrackingStates'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingState',
                description: 'The ID of the time tracking state to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved time tracking state details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(TimeTrackingState $timeTrackingState): TimeTrackingStateResource
    {
        return new TimeTrackingStateResource($timeTrackingState);
    }

    /**
     * Update the specified time tracking state in storage.
     *
     * @param TimeTrackingStateUpdateRequest $request
     * @param TimeTrackingState $timeTrackingState
     * @return TimeTrackingStateResource
     */
    #[OA\Put(
        path: '/time-tracking-states/{timeTrackingState}',
        operationId: 'updateTimeTrackingState',
        description: 'Update an existing time tracking state',
        summary: 'Update time tracking state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateUpdateRequest')
        ),
        tags: ['TimeTrackingStates'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingState',
                description: 'The ID of the time tracking state to update',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated time tracking state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStateResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking state not found',
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
    public function update(TimeTrackingStateUpdateRequest $request, TimeTrackingState $timeTrackingState): TimeTrackingStateResource
    {
        $timeTrackingState->update($request->validated());
        return new TimeTrackingStateResource($timeTrackingState);
    }

    /**
     * Remove the specified time tracking state from storage.
     *
     * @param TimeTrackingState $timeTrackingState
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/time-tracking-states/{timeTrackingState}',
        operationId: 'deleteTimeTrackingState',
        description: 'Delete a specific time tracking state',
        summary: 'Delete time tracking state',
        tags: ['TimeTrackingStates'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingState',
                description: 'The ID of the time tracking state to delete',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted time tracking state',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(TimeTrackingState $timeTrackingState): JsonResponse
    {
        $timeTrackingState->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the time tracking states resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/time-tracking-states/methods',
        operationId: 'listMethodsTimeTrackingStates',
        description: 'List all supported HTTP methods for time tracking states',
        summary: 'Supported HTTP methods',
        tags: ['TimeTrackingStates'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsTimeTrackingStatesResult',
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
