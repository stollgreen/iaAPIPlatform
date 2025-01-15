<?php

namespace App\Http\Controllers;

use App\Http\Requests\CountryStoreRequest;
use App\Http\Requests\CountryUpdateRequest;
use App\Http\Resources\CountryCollection;
use App\Http\Resources\CountryResource;
use App\Models\Country;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class CountryController
 *
 * This controller handles the main operations for country resource management,
 * including listing, creating, reading, updating, and deleting countries.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Countries',
    description: 'Operations for managing countries',
)]
class CountryController extends Controller
{
    /**
     * Display a listing of the countries.
     *
     * @return CountryCollection
     */
    #[OA\Get(
        path: '/countries',
        operationId: 'listCountries',
        description: 'Retrieve a paginated list of countries',
        summary: 'List all countries',
        security: [],
        tags: ['Countries'],
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
                description: 'Successfully retrieved list of countries',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CountryCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
            ),
        ]
    )]
    public function index(): CountryCollection
    {
        $countries = Country::paginate(request()->input('perPage'));
        return new CountryCollection($countries);
    }

    /**
     * Store a newly created country in storage.
     *
     * @param CountryStoreRequest $request
     * @return CountryResource
     */
    #[OA\Post(
        path: '/countries',
        operationId: 'createCountry',
        description: 'Create a new country',
        summary: 'Create a new country',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CountryStoreRequest')
        ),
        tags: ['Countries'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved commitment details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CountryResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ],
            ),
        ]
    )]
    public function store(CountryStoreRequest $request): CountryResource
    {
        $country = Country::create($request->validated());
        return new CountryResource($country);
    }

    /**
     * Display the specified country.
     *
     * @param Country $country
     * @return CountryResource
     */
    #[OA\Get(
        path: '/countries/{country}',
        operationId: 'showCountry',
        description: 'Retrieve details of a specific country',
        summary: 'Retrieve country details',
        tags: ['Countries'],
        parameters: [
            new OA\PathParameter(
                name: 'country',
                description: 'The ID of the country to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved commitment details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CountryResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Country $country): CountryResource
    {
        return new CountryResource($country);
    }

    /**
     * Update the specified country in storage.
     *
     * @param CountryUpdateRequest $request
     * @param Country $country
     * @return CountryResource
     */
    #[OA\Put(
        path: '/countries/{country}',
        operationId: 'updateCountry',
        description: 'Update an existing country',
        summary: 'Update a country',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CountryUpdateRequest')
        ),
        tags: ['Countries'],
        parameters: [
            new OA\PathParameter(
                name: 'country',
                description: 'The ID of the country to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated country',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/CountryResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function update(CountryUpdateRequest $request, Country $country): CountryResource
    {
        $country->update($request->validated());
        return new CountryResource($country);
    }

    /**
     * Remove the specified country from storage.
     *
     * @param Country $country
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/countries/{country}',
        operationId: 'deleteCountry',
        description: 'Delete a specific country',
        summary: 'Delete a country',
        tags: ['Countries'],
        parameters: [
            new OA\PathParameter(
                name: 'country',
                description: 'The ID of the country to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted country',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),

        ]
    )]
    public function destroy(Country $country): JsonResponse
    {
        $country->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'countries' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/countries/methods',
        operationId: 'listMethodsCountries',
        description: 'Retrieve the list of supported HTTP methods for countries',
        summary: 'List all supported HTTP methods for countries',
        tags: ['Countries'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsCountriesResult',
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
