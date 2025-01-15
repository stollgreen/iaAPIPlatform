<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTrackingChannelStoreRequest;
use App\Http\Requests\TimeTrackingChannelUpdateRequest;
use App\Http\Resources\TimeTrackingChannelCollection;
use App\Http\Resources\TimeTrackingChannelResource;
use App\Models\TimeTrackingChannel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

/**
 * Class TimeTrackingChannelController
 *
 * Handles operations for managing time tracking channels, including listing,
 * creating, updating, retrieving, and deleting channels.
 */
#[OA\Tag(
    name: 'TimeTrackingChannels',
    description: 'Operations for managing time tracking channels',
)]
class TimeTrackingChannelController extends Controller
{
    /**
     * List all time tracking channels.
     *
     * @return TimeTrackingChannelCollection
     */
    #[OA\Get(
        path: '/time-tracking-channels',
        operationId: 'listTimeTrackingChannels',
        description: 'Retrieve a paginated list of time tracking channels',
        summary: 'List time tracking channels',
        tags: ['TimeTrackingChannels'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 15),
                example: 15
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of time tracking channels',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function index(Request $request): TimeTrackingChannelCollection
    {
        $timeTrackingChannels = TimeTrackingChannel::paginate($request->input('perPage', 15));
        return new TimeTrackingChannelCollection($timeTrackingChannels);
    }

    /**
     * Create a new time tracking channel.
     *
     * @param TimeTrackingChannelStoreRequest $request
     * @return TimeTrackingChannelResource
     */
    #[OA\Post(
        path: '/time-tracking-channels',
        operationId: 'createTimeTrackingChannel',
        description: 'Create a new time tracking channel',
        summary: 'Create time tracking channel',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelStoreRequest')
        ),
        tags: ['TimeTrackingChannels'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created time tracking channel',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors occurred while creating time tracking channel',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function store(TimeTrackingChannelStoreRequest $request): TimeTrackingChannelResource
    {
        $timeTrackingChannel = TimeTrackingChannel::create($request->validated());
        return new TimeTrackingChannelResource($timeTrackingChannel);
    }

    /**
     * Retrieve a specific time tracking channel.
     *
     * @param TimeTrackingChannel $timeTrackingChannel
     * @return TimeTrackingChannelResource
     */
    #[OA\Get(
        path: '/time-tracking-channels/{timeTrackingChannel}',
        operationId: 'showTimeTrackingChannel',
        description: 'Retrieve details of a specific time tracking channel',
        summary: 'Retrieve a time tracking channel',
        tags: ['TimeTrackingChannels'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingChannel',
                description: 'The ID of the time tracking channel',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved time tracking channel',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking channel not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(TimeTrackingChannel $timeTrackingChannel): TimeTrackingChannelResource
    {
        return new TimeTrackingChannelResource($timeTrackingChannel);
    }

    /**
     * Update a specific time tracking channel.
     *
     * @param TimeTrackingChannelUpdateRequest $request
     * @param TimeTrackingChannel $timeTrackingChannel
     * @return TimeTrackingChannelResource
     */
    #[OA\Put(
        path: '/time-tracking-channels/{timeTrackingChannel}',
        operationId: 'updateTimeTrackingChannel',
        description: 'Update an existing time tracking channel',
        summary: 'Update time tracking channel',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelUpdateRequest')
        ),
        tags: ['TimeTrackingChannels'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingChannel',
                description: 'The ID of the time tracking channel',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated time tracking channel',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingChannelResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking channel not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation errors occurred while updating time tracking channel',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function update(TimeTrackingChannelUpdateRequest $request, TimeTrackingChannel $timeTrackingChannel): TimeTrackingChannelResource
    {
        $timeTrackingChannel->update($request->validated());
        return new TimeTrackingChannelResource($timeTrackingChannel);
    }

    /**
     * Delete a specific time tracking channel.
     *
     * @param TimeTrackingChannel $timeTrackingChannel
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/time-tracking-channels/{timeTrackingChannel}',
        operationId: 'deleteTimeTrackingChannel',
        description: 'Delete a specific time tracking channel',
        summary: 'Delete time tracking channel',
        tags: ['TimeTrackingChannels'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTrackingChannel',
                description: 'The ID of the time tracking channel to delete',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted time tracking channel',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking channel not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(TimeTrackingChannel $timeTrackingChannel): JsonResponse
    {
        $timeTrackingChannel->delete();
        return response()->json([], 204);
    }

    /**
     * Provide supported HTTP methods for time tracking channels.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/time-tracking-channels/methods',
        operationId: 'listMethodsTimeTrackingChannels',
        description: 'Retrieve supported HTTP methods for time tracking channels',
        summary: 'List supported HTTP methods',
        tags: ['TimeTrackingChannels'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        properties: [
                            new OA\Property(
                                property: 'methods',
                                type: 'array',
                                items: new OA\Items(type: 'string'),
                                example: ['GET', 'POST', 'PUT', 'DELETE']
                            )
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
            'methods' => ['GET', 'POST', 'PUT', 'DELETE']
        ]);
    }
}
