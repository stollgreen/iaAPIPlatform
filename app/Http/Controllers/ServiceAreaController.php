<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceAreaStoreRequest;
use App\Http\Requests\ServiceAreaUpdateRequest;
use App\Http\Resources\ServiceAreaCollection;
use App\Http\Resources\ServiceAreaResource;
use App\Models\ServiceArea;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class ServiceAreaController
 *
 * This controller handles the main operations for service area resource management,
 * including listing, creating, reading, updating, and deleting service areas.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'ServiceArea',
    description: 'Operations about ServiceArea',
)]
class ServiceAreaController extends Controller
{
    /**
     * Display a listing of the service areas.
     *
     * @return ServiceAreaCollection
     */
    #[OA\Get(
        path: '/service-areas',
        operationId: 'listServiceAreas',
        description: 'Retrieve a paginated list of service areas',
        summary: 'List all service areas',
        security: [],
        tags: ['ServiceArea'],
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
                description: 'Successfully retrieved list of service areas',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ServiceAreaCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): ServiceAreaCollection
    {
        $serviceAreas = ServiceArea::paginate(request()->input('perPage'));
        return new ServiceAreaCollection($serviceAreas);
    }

    /**
     * Store a newly created service area in storage.
     *
     * @param ServiceAreaStoreRequest $request
     * @return ServiceAreaResource
     */
    #[OA\Post(
        path: '/service-areas',
        operationId: 'createServiceArea',
        description: 'Create a new service area',
        summary: 'Create a new service area',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/ServiceAreaStoreRequest')
        ),
        tags: ['ServiceArea'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created service area',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ServiceAreaResource')
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
    public function store(ServiceAreaStoreRequest $request): ServiceAreaResource
    {
        $serviceArea = ServiceArea::create($request->validated());
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Display the specified service area.
     *
     * @param ServiceArea $serviceArea
     * @return ServiceAreaResource
     */
    #[OA\Get(
        path: '/service-areas/{serviceArea}',
        operationId: 'showServiceArea',
        description: 'Retrieve details of a service area',
        summary: 'Get service area details',
        tags: ['ServiceArea'],
        parameters: [
            new OA\PathParameter(
                name: 'serviceArea',
                description: 'The ID of the service area',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved service area details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ServiceAreaResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Service area not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(ServiceArea $serviceArea): ServiceAreaResource
    {
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Update the specified service area in storage.
     *
     * @param ServiceAreaUpdateRequest $request
     * @param ServiceArea $serviceArea
     * @return ServiceAreaResource
     */
    #[OA\Put(
        path: '/service-areas/{serviceArea}',
        operationId: 'updateServiceArea',
        description: 'Update an existing service area',
        summary: 'Update service area',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/ServiceAreaUpdateRequest')
        ),
        tags: ['ServiceArea'],
        parameters: [
            new OA\PathParameter(
                name: 'serviceArea',
                description: 'The ID of the service area to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated service area',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ServiceAreaResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Service area not found',
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
    public function update(ServiceAreaUpdateRequest $request, ServiceArea $serviceArea): ServiceAreaResource
    {
        $serviceArea->update($request->validated());
        return new ServiceAreaResource($serviceArea);
    }

    /**
     * Remove the specified service area from storage.
     *
     * @param ServiceArea $serviceArea
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/service-areas/{serviceArea}',
        operationId: 'deleteServiceArea',
        description: 'Delete a service area',
        summary: 'Delete service area',
        tags: ['ServiceArea'],
        parameters: [
            new OA\PathParameter(
                name: 'serviceArea',
                description: 'The ID of the service area to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted service area',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Service area not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(ServiceArea $serviceArea): JsonResponse
    {
        $serviceArea->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/service-areas/methods',
        operationId: 'listMethodsServiceAreas',
        description: 'Retrieve supported HTTP methods for service areas',
        summary: 'Get supported HTTP methods',
        tags: ['ServiceArea'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsServiceAreasResult',
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
