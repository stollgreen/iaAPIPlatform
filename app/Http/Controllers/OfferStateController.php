<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferStateStoreRequest;
use App\Http\Requests\OfferStateUpdateRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Http\Resources\OfferStateCollection;
use App\Http\Resources\OfferStateResource;
use App\Models\OfferState;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class OfferStateController
 *
 * This controller handles the main operations for OfferState resource management,
 * including listing, creating, reading, updating, and deleting OfferStates.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'OfferStates',
    description: 'Operations for managing offer states',
)]
class OfferStateController extends Controller
{
    /**
     * Display a listing of the OfferStates.
     *
     * @return OfferStateCollection
     */
    #[OA\Get(
        path: '/offer-states',
        operationId: 'listOfferStates',
        description: 'Retrieve a paginated list of offer states',
        summary: 'List offer states',
        security: [],
        tags: ['OfferStates'],
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
                description: 'Number of page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of offer states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferStateCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function index(): OfferStateCollection
    {
        $offerStates = OfferState::paginate(request()->input('perPage'));
        return new OfferStateCollection($offerStates);
    }

    /**
     * Store a newly created OfferState in storage.
     *
     * @param OfferStateStoreRequest $request
     * @return OfferStateResource
     */
    #[OA\Post(
        path: '/offer-states',
        operationId: 'createOfferState',
        description: 'Create a new offer state',
        summary: 'Create a new offer state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OfferStateStoreRequest')
        ),
        tags: ['OfferStates'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created offer state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function store(OfferStateStoreRequest $request): OfferStateResource
    {
        $offerState = OfferState::create($request->validated());
        return new OfferStateResource($offerState);
    }

    /**
     * Display the specified OfferState.
     *
     * @param OfferState $offerState
     * @return OfferStateResource
     */
    #[OA\Get(
        path: '/offer-states/{offerState}',
        operationId: 'showOfferState',
        description: 'Retrieve details of a specific offer state',
        summary: 'Retrieve details of a specific offer state',
        tags: ['OfferStates'],
        parameters: [
            new OA\PathParameter(
                name: 'offerState',
                description: 'The ID of the offer state to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved offer state details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Offer state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(OfferState $offerState): OfferStateResource
    {
        return new OfferStateResource($offerState);
    }

    /**
     * Retrieve a list of offers to the requested offerState
     * @param OfferState $offer_state_id
     * @return OfferCollection
     */
    #[OA\Get(
        path: '/offer-states/{offer_state_id}/offers',
        operationId: 'listOfferStateOffers',
        description: 'Retrieve a paginated list of offers to the requested offer state',
        summary: 'List offers to the requested offer state',
        tags: ['OfferStates'],
        parameters: [
            new OA\PathParameter(
                name: 'offer_state_id',
                description: 'The ID of the offer state to retrieve offers for',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer', example: 1),
            ),
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', example: 5),
                example: 5,
            ),
            new OA\QueryParameter(
                name: 'page',
                description: 'Number of page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: '1'), // Optional: Standardwert
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved offers states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Requested offer state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function offers(OfferState $offer_state_id): OfferCollection
    {
        return new OfferCollection(
            $offer_state_id
                ->offers()
                ->paginate(
                    request()
                        ->input(
                            'perPage', 5
                        )
                )
        );
    }

    /**
     * Update the specified OfferState in storage.
     *
     * @param OfferStateUpdateRequest $request
     * @param OfferState $offerState
     * @return OfferStateResource
     */
    #[OA\Put(
        path: '/offer-states/{offerState}',
        operationId: 'updateOfferState',
        description: 'Update an existing offer state',
        summary: 'Update an existing offer state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OfferStateUpdateRequest')
        ),
        tags: ['OfferStates'],
        parameters: [
            new OA\PathParameter(
                name: 'offerState',
                description: 'The ID of the offer state to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully updated offer state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Requested offer state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation Error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function update(OfferStateUpdateRequest $request, OfferState $offerState): OfferStateResource
    {
        $offerState->update($request->validated());
        return new OfferStateResource($offerState);
    }

    /**
     * Remove the specified OfferState from storage.
     *
     * @param OfferState $offerState
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/offer-states/{offerState}',
        operationId: 'deleteOfferState',
        description: 'Delete a specific offer state',
        summary: 'Delete a specific offer state',
        tags: ['OfferStates'],
        parameters: [
            new OA\PathParameter(
                name: 'offerState',
                description: 'The ID of the offer state to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted offer state',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Requested offer state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(OfferState $offerState): JsonResponse
    {
        $offerState->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/offer-states/methods',
        operationId: 'listMethodsOfferStates',
        description: 'Retrieve the list of supported HTTP methods for offer states',
        summary: 'List all supported HTTP methods for offer states',
        tags: ['OfferStates'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsOfferStatesResult',
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
