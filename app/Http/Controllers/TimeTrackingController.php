<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimeTrackingStoreRequest;
use App\Http\Requests\TimeTrackingUpdateRequest;
use App\Http\Resources\TimeTrackingCollection;
use App\Http\Resources\TimeTrackingResource;
use App\Models\TimeTracking;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class TimeTrackingController
 *
 * This controller handles the main operations for time tracking resource management,
 * including listing, creating, reading, updating, and deleting time tracking entries.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'TimeTrackings',
    description: 'Operations for managing time tracking entries',
)]
class TimeTrackingController extends Controller
{
    /**
     * Display a listing of the time trackings.
     *
     * @return TimeTrackingCollection
     */
    #[OA\Get(
        path: '/time-trackings',
        operationId: 'listTimeTrackings',
        description: 'Retrieve a paginated list of time tracking entries',
        summary: 'List time tracking entries',
        security: [],
        tags: ['TimeTrackings'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 5),
                example: 15
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
                description: 'Successfully retrieved list of time tracking entries',
                x: [
                    new OA\JsonContent(
                        ref: '#/components/schemas/TimeTrackingCollection'
                    ),
                    new OA\Response(
                        ref: '#/components/responses/Default',
                    )
                ]
            )
        ]
    )]
    public function index(): TimeTrackingCollection
    {
        $timeTrackings = TimeTracking::paginate(request()->input('perPage'));
        return new TimeTrackingCollection($timeTrackings);
    }

    /**
     * Store a newly created time tracking entry in storage.
     *
     * @param TimeTrackingStoreRequest $request
     * @return TimeTrackingResource
     */
    #[OA\Post(
        path: '/time-trackings',
        operationId: 'createTimeTracking',
        description: 'Create a new time tracking entry',
        summary: 'Create a new time tracking entry',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingStoreRequest')
        ),
        tags: ['TimeTrackings'],
        responses: [
            new OA\Response(
                response: "default",
                description: 'Successfully created time tracking entry',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ],
            ),
        ],
    )]
    public function store(TimeTrackingStoreRequest $request): TimeTrackingResource
    {
        $timeTracking = TimeTracking::create($request->validated());
        return new TimeTrackingResource($timeTracking);
    }

    /**
     * Display the specified time tracking entry.
     *
     * @param TimeTracking $timeTracking
     * @return TimeTrackingResource
     */
    #[OA\Get(
        path: '/time-trackings/{timeTracking}',
        operationId: 'showTimeTracking',
        description: 'Retrieve details of a specific time tracking entry',
        summary: 'Retrieve details of a specific time tracking entry',
        tags: ['TimeTrackings'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTracking',
                description: 'The ID of the time tracking entry to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved time tracking entry details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
            ),
        ]
    )]
    public function show(TimeTracking $timeTracking): TimeTrackingResource
    {
        return new TimeTrackingResource($timeTracking);
    }

    /**
     * Update the specified time tracking entry in storage.
     *
     * @param TimeTrackingUpdateRequest $request
     * @param TimeTracking $timeTracking
     * @return TimeTrackingResource
     */
    #[OA\Put(
        path: '/time-trackings/{timeTracking}',
        operationId: 'updateTimeTracking',
        description: 'Update an existing time tracking entry',
        summary: 'Update an existing time tracking entry',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/TimeTrackingUpdateRequest')
        ),
        tags: ['TimeTrackings'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTracking',
                description: 'The ID of the time tracking entry to update',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            )],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated time tracking entry',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/TimeTrackingResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function update(TimeTrackingUpdateRequest $request, TimeTracking $timeTracking): TimeTrackingResource
    {
        $timeTracking->update($request->validated());
        return new TimeTrackingResource($timeTracking);
    }

    /**
     * Remove the specified time tracking entry from storage.
     *
     * @param TimeTracking $timeTracking
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/time-trackings/{timeTracking}',
        operationId: 'deleteTimeTracking',
        description: 'Delete a specific time tracking entry',
        summary: 'Delete a specific time tracking entry',
        tags: ['TimeTrackings'],
        parameters: [
            new OA\PathParameter(
                name: 'timeTracking',
                description: 'The ID of the time tracking entry to delete',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1)
            ),
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted time tracking entry',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Time tracking entry not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(TimeTracking $timeTracking): JsonResponse
    {
        $timeTracking->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'time trackings' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/time-trackings/methods',
        operationId: 'listMethodsTimeTrackings',
        description: 'Retrieve the list of supported HTTP methods for time trackings',
        summary: 'List all supported HTTP methods for time trackings',
        tags: ['TimeTrackings'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsTimeTrackingsResult',
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
