<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferStoreRequest;
use App\Http\Requests\OfferUpdateRequest;
use App\Http\Resources\OfferCollection;
use App\Http\Resources\OfferResource;
use App\Models\Offer;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class OfferController
 *
 * This controller manages operations for offer resources, providing
 * functionalities to list, create, read, update, and delete offers.
 * It also specifies supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Offers',
    description: 'Operations for managing offers',
)]
class OfferController extends Controller
{
    /**
     * Display a listing of the offers.
     *
     * @return OfferCollection
     */
    #[OA\Get(
        path: '/offers',
        operationId: 'listOffers',
        description: 'Retrieve a paginated list of offers',
        summary: 'List offers',
        tags: ['Offers'],
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
                description: 'Successfully retrieved list of offers',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): OfferCollection
    {
        $offers = Offer::paginate(request()->input('perPage'));
        return new OfferCollection($offers);
    }

    /**
     * Handles the creation of a new offer.
     *
     * @param OfferStoreRequest $request
     * @return OfferResource
     */
    #[OA\Post(
        path: '/offers',
        operationId: 'createOffer',
        description: 'Create a new offer',
        summary: 'Create a new offer',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OfferStoreRequest')
        ),
        tags: ['Offers'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created offer',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferResource'),
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
    public function store(OfferStoreRequest $request): OfferResource
    {
        $offer = Offer::create($request->validated());
        return new OfferResource($offer);
    }

    /**
     * Display the specified offer.
     *
     * @param Offer $offer
     * @return OfferResource
     */
    #[OA\Get(
        path: '/offers/{offer}',
        operationId: 'showOffer',
        description: 'Retrieve details of a specific offer',
        summary: 'Retrieve a specific offer',
        tags: ['Offers'],
        parameters: [
            new OA\PathParameter(
                name: 'offer',
                description: 'The ID of the offer to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved offer details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Offer not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Offer $offer): OfferResource
    {
        return new OfferResource($offer);
    }

    /**
     * Update the specified offer in storage.
     *
     * @param OfferUpdateRequest $request
     * @param Offer $offer
     * @return OfferResource
     */
    #[OA\Put(
        path: '/offers/{offer}',
        operationId: 'updateOffer',
        description: 'Update an existing offer',
        summary: 'Update an offer',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/OfferUpdateRequest')
        ),
        tags: ['Offers'],
        parameters: [
            new OA\PathParameter(
                name: 'offer',
                description: 'The ID of the offer to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated offer',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/OfferResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Offer not found',
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
    public function update(OfferUpdateRequest $request, Offer $offer): OfferResource
    {
        $offer->update($request->validated());
        return new OfferResource($offer);
    }

    /**
     * Remove the specified offer from storage.
     *
     * @param Offer $offer
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/offers/{offer}',
        operationId: 'deleteOffer',
        description: 'Delete an offer',
        summary: 'Delete an offer',
        tags: ['Offers'],
        parameters: [
            new OA\PathParameter(
                name: 'offer',
                description: 'The ID of the offer to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted offer',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Offer not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(Offer $offer): JsonResponse
    {
        $offer->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the offers resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/offers/methods',
        operationId: 'listMethodsOffers',
        description: 'Retrieve the list of supported HTTP methods for offers',
        summary: 'List supported HTTP methods for offers',
        tags: ['Offers'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsOffersResult',
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
