<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationStoreRequest;
use App\Http\Requests\LocationUpdateRequest;
use App\Http\Resources\LocationCollection;
use App\Http\Resources\LocationResource;
use App\Models\Location;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class LocationController
 *
 * This controller handles the main operations for location resource management,
 * including listing, creating, reading, updating, and deleting locations.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Locations',
    description: 'Operations for managing locations',
)]
class LocationController extends Controller
{
    /**
     * Display a listing of the locations.
     *
     * @return LocationCollection
     */
    #[OA\Get(
        path: '/locations',
        operationId: 'listLocations',
        description: 'Retrieve a paginated list of locations',
        summary: 'List locations',
        tags: ['Locations'],
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
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of locations',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/LocationCollection'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): LocationCollection
    {
        $locations = Location::paginate(request()->input('perPage'));
        return new LocationCollection($locations);
    }

    /**
     * Store a newly created location in storage.
     *
     * @param LocationStoreRequest $request
     * @return LocationResource
     */
    #[OA\Post(
        path: '/locations',
        operationId: 'createLocation',
        description: 'Create a new location',
        summary: 'Create location',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/LocationStoreRequest')
        ),
        tags: ['Locations'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created location',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/LocationResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
            )
        ]
    )]
    public function store(LocationStoreRequest $request): LocationResource
    {
        $location = Location::create($request->validated());
        return new LocationResource($location);
    }

    /**
     * Display the specified location.
     *
     * @param Location $location
     * @return LocationResource
     */
    #[OA\Get(
        path: '/locations/{location}',
        operationId: 'showLocation',
        description: 'Retrieve details of a specific location',
        summary: 'Retrieve location details',
        tags: ['Locations'],
        parameters: [
            new OA\PathParameter(
                name: 'location',
                description: 'The ID of the location to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved location details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/LocationResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Location not found',
            ),

        ]
    )]
    public function show(Location $location): LocationResource
    {
        return new LocationResource($location);
    }

    /**
     * Update the specified location in storage.
     *
     * @param LocationUpdateRequest $request
     * @param Location $location
     * @return LocationResource
     */
    #[OA\Put(
        path: '/locations/{location}',
        operationId: 'updateLocation',
        description: 'Update an existing location',
        summary: 'Update location',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/LocationUpdateRequest')
        ),
        tags: ['Locations'],
        parameters: [
            new OA\PathParameter(
                name: 'location',
                description: 'The ID of the location to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated location',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/LocationResource'),
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Location not found',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function update(LocationUpdateRequest $request, Location $location): LocationResource
    {
        $location->update($request->validated());
        return new LocationResource($location);
    }

    /**
     * Remove the specified location from storage.
     *
     * @param Location $location
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/locations/{location}',
        operationId: 'deleteLocation',
        description: 'Delete a specific location',
        summary: 'Delete location',
        tags: ['Locations'],
        parameters: [
            new OA\PathParameter(
                name: 'location',
                description: 'The ID of the location to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted location',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Location not found',
                x: [
                    new OA\Response('#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function destroy(Location $location): JsonResponse
    {
        $location->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'locations' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/locations/methods',
        operationId: 'listMethodsLocations',
        description: 'Retrieve the list of supported HTTP methods for locations',
        summary: 'List supported HTTP methods for locations',
        tags: ['Locations'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsLocationsResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response('#/components/responses/Default')
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
