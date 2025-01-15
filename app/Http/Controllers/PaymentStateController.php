<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentStateStoreRequest;
use App\Http\Requests\PaymentStateUpdateRequest;
use App\Http\Resources\PaymentStateCollection;
use App\Http\Resources\PaymentStateResource;
use App\Models\PaymentState;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class PaymentStateController
 *
 * This controller handles the main operations for payment state resource management,
 * including listing, creating, reading, updating, and deleting payment states.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Payment States',
    description: 'Operations for managing payment states',
)]
class PaymentStateController extends Controller
{
    /**
     * Display a listing of the payment states.
     *
     * @return PaymentStateCollection
     */
    #[OA\Get(
        path: '/payment-states',
        operationId: 'listPaymentStates',
        description: 'Retrieve a paginated list of payment states',
        summary: 'List payment states',
        tags: ['Payment States'],
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
                description: 'Successfully retrieved list of payment states',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PaymentStateCollection'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function index(): PaymentStateCollection
    {
        $paymentStates = PaymentState::paginate(request()->input('perPage'));
        return new PaymentStateCollection($paymentStates);
    }

    /**
     * Store a newly created payment state in storage.
     *
     * @param PaymentStateStoreRequest $request
     * @return PaymentStateResource
     */
    #[OA\Post(
        path: '/payment-states',
        operationId: 'createPaymentState',
        description: 'Create a new payment state',
        summary: 'Create a new payment state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PaymentStateStoreRequest')
        ),
        tags: ['Payment States'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created payment state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PaymentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
        ]
    )]
    public function store(PaymentStateStoreRequest $request): PaymentStateResource
    {
        $paymentState = PaymentState::create($request->validated());
        return new PaymentStateResource($paymentState);
    }

    /**
     * Display the specified payment state.
     *
     * @param PaymentState $paymentState
     * @return PaymentStateResource
     */
    #[OA\Get(
        path: '/payment-states/{paymentState}',
        operationId: 'showPaymentState',
        description: 'Retrieve details of a specific payment state',
        summary: 'Retrieve details of a specific payment state',
        tags: ['Payment States'],
        parameters: [
            new OA\PathParameter(
                name: 'paymentState',
                description: 'The ID of the payment state to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved payment state details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PaymentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Payment state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function show(PaymentState $paymentState): PaymentStateResource
    {
        return new PaymentStateResource($paymentState);
    }

    /**
     * Update the specified payment state in storage.
     *
     * @param PaymentStateUpdateRequest $request
     * @param PaymentState $paymentState
     * @return PaymentStateResource
     */
    #[OA\Put(
        path: '/payment-states/{paymentState}',
        operationId: 'updatePaymentState',
        description: 'Update an existing payment state',
        summary: 'Update an existing payment state',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/PaymentStateUpdateRequest')
        ),
        tags: ['Payment States'],
        parameters: [
            new OA\PathParameter(
                name: 'paymentState',
                description: 'The ID of the payment state to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated payment state',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/PaymentStateResource'),
                    new OA\Response(ref: '#/components/responses/Default'),

                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Payment state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function update(PaymentStateUpdateRequest $request, PaymentState $paymentState): PaymentStateResource
    {
        $paymentState->update($request->validated());
        return new PaymentStateResource($paymentState);
    }

    /**
     * Remove the specified payment state from storage.
     *
     * @param PaymentState $paymentState
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/payment-states/{paymentState}',
        operationId: 'deletePaymentState',
        description: 'Delete a specific payment state',
        summary: 'Delete a specific payment state',
        tags: ['Payment States'],
        parameters: [
            new OA\PathParameter(
                name: 'paymentState',
                description: 'The ID of the payment state to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted payment state',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Payment state not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default'),
                ]
            )
        ]
    )]
    public function destroy(PaymentState $paymentState): JsonResponse
    {
        $paymentState->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/payment-states/methods',
        operationId: 'listMethodsPaymentStates',
        description: 'Retrieve the list of supported HTTP methods for payment states',
        summary: 'List all supported HTTP methods for payment states',
        tags: ['Payment States'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsPaymentStatesResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
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
            'methods' => [
                'GET', 'POST', 'PUT', 'DELETE'
            ]
        ]);
    }
}
