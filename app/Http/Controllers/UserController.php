<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class UserController
 *
 * This controller handles the main operations for user resource management,
 * including listing, creating, reading, updating, and deleting users.
 * It also provides supported HTTP methods for the resource.
 */

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return UserCollection
     */
    #[OA\Get(
        path: '/users',
        operationId: "listUsers",
        description: 'Retrieve a paginated list of users',
        summary: 'List users',
        security: [],
        tags: ['Users'],
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
                description: 'Successfully retrieved list of users',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/UserCollection'),
                    new OA\Response(ref: '#/components/responses/Default', response: 'default')
                ]
            )
        ]
    )]
    public function index(): UserCollection
    {
        $users = User::paginate(request()->input('perPage'));
        return new UserCollection($users);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param UserStoreRequest $request
     * @return UserResource
     */
    #[OA\Post(
        path: '/users',
        operationId: "createUser",
        description: 'Create a new user',
        summary: 'Create a new user',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UserStoreRequest')
        ),
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created user',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/UserResource'),
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
    public function store(UserStoreRequest $request): UserResource
    {
        $user = User::create($request->validated());
        return new UserResource($user);
    }

    /**
     * Display the specified user.
     *
     * @param User $user
     * @return UserResource
     */
    #[OA\Get(
        path: '/users/{user}',
        operationId: "showUser",
        description: 'Retrieve details of a specific user',
        summary: 'Retrieve user details',
        tags: ['Users'],
        parameters: [
            new OA\PathParameter(
                name: 'user',
                description: 'The ID of the user to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved user details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/UserResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(User $user): UserResource
    {
        return new UserResource($user);
    }

    /**
     * Update the specified user in storage.
     *
     * @param UserUpdateRequest $request
     * @param User $user
     * @return UserResource
     */
    #[OA\Put(
        path: '/users/{user}',
        operationId: "updateUser",
        description: 'Update an existing user',
        summary: 'Update user details',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/UserUpdateRequest')
        ),
        tags: ['Users'],
        parameters: [
            new OA\PathParameter(
                name: 'user',
                description: 'The ID of the user to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated user',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/UserResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'User not found',
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
    public function update(UserUpdateRequest $request, User $user): UserResource
    {
        $user->update($request->validated());
        return new UserResource($user);
    }

    /**
     * Remove the specified user from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
//    #[OA\Delete(
//        path: '/users/{user}',
//        description: 'Delete a specific user',
//        summary: 'Delete user',
//        tags: ['Users'],
//        parameters: [
//            new OA\PathParameter(
//                name: 'user',
//                description: 'The ID of the user to delete',
//                required: true,
//                schema: new OA\Schema(type: 'integer')
//            )
//        ],
//        responses: [
//            new OA\Response(
//                response: 204,
//                description: 'Successfully deleted user'
//            )
//        ]
//    )]
//    public function destroy(User $user): JsonResponse
//    {
//        $user->delete();
//        return response()->json([], 204);
//    }

    /**
     * Return supported HTTP methods for the 'users' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/users/methods',
        operationId: 'listMethodsUsers',
        description: 'Retrieve the list of supported HTTP methods for users',
        summary: 'List supported HTTP methods',
        tags: ['Users'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsUsers',
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