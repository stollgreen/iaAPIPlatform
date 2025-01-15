<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventStoreRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventCollection;
use App\Http\Resources\EventResource;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class EventController
 *
 * This controller handles the main operations for event resource management,
 * including listing, creating, reading, updating, and deleting events.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Events',
    description: 'Operations for managing events',
)]
class EventController extends Controller
{
    /**
     * Display a listing of the events.
     *
     * @return EventCollection
     */
    #[OA\Get(
        path: '/events',
        operationId: 'listEvents',
        description: 'Retrieve a paginated list of events',
        summary: 'List events',
        security: [],
        tags: ['Events'],
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
                schema: new OA\Schema(type: 'integer', default: '1'),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of events',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): EventCollection
    {
        $events = Event::paginate(request()->input('perPage'));
        return new EventCollection($events);
    }

    /**
     * Store a newly created event in storage.
     *
     * @param EventStoreRequest $request
     * @return EventResource
     */
    #[OA\Post(
        path: '/events',
        operationId: 'createEvent',
        description: 'Create a new event',
        summary: 'Create a new event',
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\JsonContent(ref: '#/components/schemas/EventStoreRequest')
            ]
        ),
        tags: ['Events'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created event',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function store(EventStoreRequest $request): EventResource
    {
        $event = Event::create($request->validated());
        return new EventResource($event);
    }

    /**
     * Display the specified event.
     *
     * @param Event $event
     * @return EventResource
     */
    #[OA\Get(
        path: '/events/{event}',
        operationId: 'showEvent',
        description: 'Retrieve details of a specific event',
        summary: 'Retrieve details of a specific event',
        tags: ['Events'],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'The ID of the event to retrieve',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved event details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Event $event): EventResource
    {
        return new EventResource($event);
    }

    /**
     * Update the specified event in storage.
     *
     * @param EventUpdateRequest $request
     * @param Event $event
     * @return EventResource
     */
    #[OA\Put(
        path: '/events/{event}',
        operationId: 'updateEvent',
        description: 'Update an existing event',
        summary: 'Update an existing event',
        requestBody: new OA\RequestBody(
            required: true,
            content: [
                new OA\JsonContent(ref: '#/components/schemas/EventUpdateRequest')
            ]
        ),
        tags: ['Events'],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'The ID of the event to update',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated event',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/EventResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function update(EventUpdateRequest $request, Event $event): EventResource
    {
        $event->update($request->validated());
        return new EventResource($event);
    }

    /**
     * Remove the specified event from storage.
     *
     * @param Event $event
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/events/{event}',
        operationId: 'deleteEvent',
        description: 'Delete a specific event',
        summary: 'Delete a specific event',
        tags: ['Events'],
        parameters: [
            new OA\Parameter(
                name: 'event',
                description: 'The ID of the event to delete',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted event',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(Event $event): JsonResponse
    {
        $event->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'events' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/events/methods',
        operationId: 'listMethodsEvents',
        description: 'Retrieve the list of supported HTTP methods for events',
        summary: 'List all supported HTTP methods for events',
        tags: ['Events'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsEventsResult',
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
