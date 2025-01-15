<?php

namespace App\Http\Controllers;

use App\Http\Requests\InvoiceStoreRequest;
use App\Http\Requests\InvoiceUpdateRequest;
use App\Http\Resources\InvoiceCollection;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvoiceController
 *
 * This controller handles the main operations for invoice resource management,
 * including listing, creating, reading, updating, and deleting invoices.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Invoices',
    description: 'Operations for managing invoices',
)]
class InvoiceController extends Controller
{
    /**
     * Display a listing of the invoices.
     *
     * @return InvoiceCollection
     */
    #[OA\Get(
        path: '/invoices',
        operationId: 'listInvoices',
        description: 'Retrieve a paginated list of invoices',
        summary: 'List invoices',
        security: [],
        tags: ['Invoices'],
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
                description: 'Page number',
                required: false,
                schema: new OA\Schema(type: 'integer', default: 1),
                example: 1
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved list of invoices',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InvoiceCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
        ]
    )]
    public function index(): InvoiceCollection
    {
        $invoices = Invoice::paginate(request()->input('perPage'));
        return new InvoiceCollection($invoices);
    }

    /**
     * Store a newly created invoice in storage.
     *
     * @param InvoiceStoreRequest $request
     * @return InvoiceResource
     */
    #[OA\Post(
        path: '/invoices',
        operationId: 'createInvoice',
        description: 'Create a new invoice',
        summary: 'Create a new invoice',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InvoiceStoreRequest')
        ),
        tags: ['Invoices'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created invoice',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InvoiceResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error',
            )
        ]
    )]
    public function store(InvoiceStoreRequest $request): InvoiceResource
    {
        $invoice = Invoice::create($request->validated());
        return new InvoiceResource($invoice);
    }

    /**
     * Display the specified invoice.
     *
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    #[OA\Get(
        path: '/invoices/{invoice}',
        operationId: 'showInvoice',
        description: 'Retrieve details of a specific invoice',
        summary: 'Retrieve details of a specific invoice',
        tags: ['Invoices'],
        parameters: [
            new OA\PathParameter(
                name: 'invoice',
                description: 'The ID of the invoice to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved invoice details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InvoiceResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Invoice not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Invoice $invoice): InvoiceResource
    {
        return new InvoiceResource($invoice);
    }

    /**
     * Update the specified invoice in storage.
     *
     * @param InvoiceUpdateRequest $request
     * @param Invoice $invoice
     * @return InvoiceResource
     */
    #[OA\Put(
        path: '/invoices/{invoice}',
        operationId: 'updateInvoice',
        description: 'Update an existing invoice',
        summary: 'Update an existing invoice',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/InvoiceUpdateRequest')
        ),
        tags: ['Invoices'],
        parameters: [
            new OA\PathParameter(
                name: 'invoice',
                description: 'The ID of the invoice to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated invoice',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/InvoiceResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 422,
                description: 'Validation error'
            ),
            new OA\Response(
                response: 404,
                description: 'Invoice not found'
            )

        ]
    )]
    public function update(InvoiceUpdateRequest $request, Invoice $invoice): InvoiceResource
    {
        $invoice->update($request->validated());
        return new InvoiceResource($invoice);
    }

    /**
     * Remove the specified invoice from storage.
     *
     * @param Invoice $invoice
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/invoices/{invoice}',
        operationId: 'deleteInvoice',
        description: 'Delete a specific invoice',
        summary: 'Delete a specific invoice',
        tags: ['Invoices'],
        parameters: [
            new OA\PathParameter(
                name: 'invoice',
                description: 'The ID of the invoice to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted invoice',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Invoice not found',
            )
        ]
    )]
    public function destroy(Invoice $invoice): JsonResponse
    {
        $invoice->delete();
        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    /**
     * Return supported HTTP methods for the 'invoices' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/invoices/methods',
        operationId: 'listMethodsInvoices',
        description: 'Retrieve the list of supported HTTP methods for invoices',
        summary: 'List all supported HTTP methods for invoices',
        tags: ['Invoices'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsInvoicesResult',
                        properties: [
                            new OA\Property(property: 'methods', type: 'array', items: new OA\Items(type: 'string'), example: ['GET', 'POST', 'PUT', 'DELETE'])
                        ],
                        type: 'object'
                    ),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
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
