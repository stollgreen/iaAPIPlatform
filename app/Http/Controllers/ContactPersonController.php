<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactPersonStoreRequest;
use App\Http\Requests\ContactPersonUpdateRequest;
use App\Http\Resources\ContactPersonCollection;
use App\Http\Resources\ContactPersonResource;
use App\Models\ContactPerson;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class ContactPersonController
 *
 * This controller handles the main operations for contact person resource management,
 * including listing, creating, reading, updating, and deleting contact persons.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'ContactPersons',
    description: 'Operations for managing contact persons',
)]
class ContactPersonController extends Controller
{
    /**
     * Display a listing of the contact persons.
     *
     * @return ContactPersonCollection
     */
    #[OA\Get(
        path: '/contact-persons',
        operationId: 'listContactPersons',
        description: 'Retrieve a paginated list of contact persons',
        summary: 'List contact persons',
        security: [],
        tags: ['ContactPersons'],
        parameters: [
            new OA\QueryParameter(
                name: 'perPage',
                description: 'Number of items per page',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 5),
                example: +5
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
                description: 'Successfully retrieved list of contact persons',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ContactPersonCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): ContactPersonCollection
    {
        $contactPersons = ContactPerson::paginate(request()->input('perPage'));
        return new ContactPersonCollection($contactPersons);
    }

    /**
     * Store a newly created contact person in storage.
     *
     * @param ContactPersonStoreRequest $request
     * @return ContactPersonResource
     */
    #[OA\Post(
        path: '/contact-persons',
        operationId: 'createContactPerson',
        description: 'Create a new contact person',
        summary: 'Create a new contact person',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/ContactPersonStoreRequest')
        ),
        tags: ['ContactPersons'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created contact person',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ContactPersonResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function store(ContactPersonStoreRequest $request): ContactPersonResource
    {
        $contactPerson = ContactPerson::create($request->validated());
        return new ContactPersonResource($contactPerson);
    }

    /**
     * Display the specified contact person.
     *
     * @param ContactPerson $contactPerson
     * @return ContactPersonResource
     */
    #[OA\Get(
        path: '/contact-persons/{contactPerson}',
        operationId: 'showContactPerson',
        description: 'Retrieve details of a specific contact person',
        summary: 'Retrieve details of a specific contact person',
        tags: ['ContactPersons'],
        parameters: [
            new OA\PathParameter(
                name: 'contactPerson',
                description: 'The ID of the contact person to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved contact person details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ContactPersonResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function show(ContactPerson $contactPerson): ContactPersonResource
    {
        return new ContactPersonResource($contactPerson);
    }

    /**
     * Update the specified contact person in storage.
     *
     * @param ContactPersonUpdateRequest $request
     * @param ContactPerson $contactPerson
     * @return ContactPersonResource
     */
    #[OA\Put(
        path: '/contact-persons/{contactPerson}',
        operationId: 'updateContactPerson',
        description: 'Update an existing contact person',
        summary: 'Update an existing contact person',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/ContactPersonUpdateRequest')
        ),
        tags: ['ContactPersons'],
        parameters: [
            new OA\PathParameter(
                name: 'contactPerson',
                description: 'The ID of the contact person to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully updated contact person',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/ContactPersonResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function update(ContactPersonUpdateRequest $request, ContactPerson $contactPerson): ContactPersonResource
    {
        $contactPerson->update($request->validated());
        return new ContactPersonResource($contactPerson);
    }

    /**
     * Remove the specified contact person from storage.
     *
     * @param ContactPerson $contactPerson
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/contact-persons/{contactPerson}',
        operationId: 'deleteContactPerson',
        description: 'Delete a specific contact person',
        summary: 'Delete a specific contact person',
        tags: ['ContactPersons'],
        parameters: [
            new OA\PathParameter(
                name: 'contactPerson',
                description: 'The ID of the contact person to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted contact person',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(ContactPerson $contactPerson): JsonResponse
    {
        $contactPerson->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/contact-persons/methods',
        operationId: 'listMethodsContactPersons',
        description: 'Retrieve the list of supported HTTP methods for contact persons',
        summary: 'List all supported HTTP methods for contact persons',
        tags: ['ContactPersons'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsContactPersonsResult',
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
