<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStateStoreRequest;
use App\Http\Requests\EventStateUpdateRequest;
use App\Http\Resources\EventStateCollection;
use App\Http\Resources\EventStateResource;
use App\Models\EventState;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class EventStateController
 *
 * This controller handles the main operations for event state resource management,
 * including listing, creating, reading, updating, and deleting event states.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Event States',
    description: 'Operations for managing event states'
)]
class EventStateController extends Controller
{
    /**
     * Display a listing of the event states.
     *
     * @return EventStateCollection
     */
    #[OA\Get(
        path: '/event-states',
        operationId: 'listEventStates',
        description: 'Retrieve a paginated list of event states',
        summary: 'List event states',
        tags: ['Event States'],
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
                description: 'Successfully retrieved list of event states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventStateCollection'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): EventStateCollection
    {
        $eventStates = EventState::paginate(request()->input('perPage'));
        return new EventStateCollection($eventStates);
    }

    /**
     * Store a newly created event state in storage.
     *
     * @param EventStateStoreRequest $request
     * @return EventStateResource
     */
    #[OA\Post(
        path: '/event-states',
        operationId: 'createEventState',
        description: 'Create a new event state',
        summary: 'Create a new event state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EventStateStoreRequest')
        ),
        tags: ['Event States'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created event state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventStateResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function store(EventStateStoreRequest $request): EventStateResource
    {
        $eventState = EventState::create($request->validated());
        return new EventStateResource($eventState);
    }

    /**
     * Display the specified event state.
     *
     * @param EventState $eventState
     * @return EventStateResource
     */
    #[OA\Get(
        path: '/event-states/{eventState}',
        operationId: 'showEventState',
        description: 'Retrieve details of a specific event state',
        summary: 'Retrieve details of a specific event state',
        tags: ['Event States'],
        parameters: [
            new OA\PathParameter(
                name: 'eventState',
                description: 'The ID of the event state to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved event state details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventStateResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(EventState $eventState): EventStateResource
    {
        return new EventStateResource($eventState);
    }

    /**
     * Update the specified event state in storage.
     *
     * @param EventStateUpdateRequest $request
     * @param EventState $eventState
     * @return EventStateResource
     */
    #[OA\Put(
        path: '/event-states/{eventState}',
        operationId: 'updateEventState',
        description: 'Update an existing event state',
        summary: 'Update an existing event state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/EventStateUpdateRequest')
        ),
        tags: ['Event States'],
        parameters: [
            new OA\PathParameter(
                name: 'eventState',
                description: 'The ID of the event state to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated event state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventStateResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function update(EventStateUpdateRequest $request, EventState $eventState): EventStateResource
    {
        $eventState->update($request->validated());
        return new EventStateResource($eventState);
    }

    /**
     * Remove the specified event state from storage.
     *
     * @param EventState $eventState
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/event-states/{eventState}',
        operationId: 'deleteEventState',
        description: 'Delete a specific event state',
        summary: 'Delete a specific event state',
        tags: ['Event States'],
        parameters: [
            new OA\PathParameter(
                name: 'eventState',
                description: 'The ID of the event state to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted event state',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function destroy(EventState $eventState): JsonResponse
    {
        $eventState->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'event-states' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/event-states/methods',
        operationId: 'listMethodsEventStates',
        description: 'Retrieve the list of supported HTTP methods for event states',
        summary: 'List all supported HTTP methods for event states',
        tags: ['Event States'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsEventStatesResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response('#/components/responses/Default'),
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
