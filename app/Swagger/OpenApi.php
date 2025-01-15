<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;
#[OA\Info(
    version: '1.0.0',
    description: 'API for managing employees in the company',
    title: 'HR-Tool API',
    contact: new OA\Contact(
        name: 'Support Team',
        url: 'https://localhost:8000',
        email: 'support@mail.none'
    ),
    license: new OA\License(
        name: 'MIT',
        url: 'https://opensource.org/licenses/MIT'
    )
)]

#[OA\Components(
    responses: [
        'Default' => new OA\Response(
            response: 'Default',
            description: 'Default response',
            headers: [
                'Date' => new OA\Header(ref: '#/components/headers/Date', header: 'Date'),
                'Server' => new OA\Header(ref: '#/components/headers/Server', header: 'Server'),
                'X-Powered-By' => new OA\Header(ref: '#/components/headers/X-Powered-By', header: 'X-Powered-By'),
                'X-RateLimit-Limit' => new OA\Header(ref: '#/components/headers/X-RateLimit-Limit', header: 'X-RateLimit-Limit'),
                'X-RateLimit-Remaining' => new OA\Header(ref: '#/components/headers/X-RateLimit-Remaining', header: 'X-RateLimit-Remaining'),
                'Access-Control-Allow-Origin' => new OA\Header(ref: '#/components/headers/Access-Control-Allow-Origin', header: 'Access-Control-Allow-Origin'),
                'Access-Control-Allow-Methods' => new OA\Header(ref: '#/components/headers/Access-Control-Allow-Methods', header: 'Access-Control-Allow-Methods'),
                'Access-Control-Allow-Headers' => new OA\Header(ref: '#/components/headers/Access-Control-Allow-Headers', header: 'Access-Control-Allow-Headers'),
                'Keep-Alive' => new OA\Header(ref: '#/components/headers/Keep-Alive', header: 'Keep-Alive'),
                'Connection' => new OA\Header(ref: '#/components/headers/Connection', header: 'Connection'),
                'Transfer-Encoding' => new OA\Header(ref: '#/components/headers/Transfer-Encoding', header: 'Transfer-Encoding'),
                'Cache-Control' => new OA\Header(ref: '#/components/headers/Cache-Control', header: 'Cache-Control'),
            ],
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                )
            )
        )
    ],
    headers: [
        'Date' => new OA\Header(
            header: 'Date',
            description: 'Date of the request',
            schema: new OA\Schema(type: 'string', format: 'date-time')
        ),
        'Server' => new OA\Header(
            header: 'Server',
            description: 'The server that processed the request',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'X-RateLimit-Limit' => new OA\Header(
            header: 'X-RateLimit-Limit',
            description: 'The number of allowed requests in the current period',
            schema: new OA\Schema(
                type: 'integer'
            )
        ),
        'X-RateLimit-Remaining' => new OA\Header(
            header: 'X-RateLimit-Remaining',
            description: 'The number of remaining requests in the current period',
            schema: new OA\Schema(
                type: 'integer'
            )
        ),
        'X-Powered-By' => new OA\Header(
            header: 'X-Powered-By',
            description: 'The technology powering the API',
            schema: new OA\Schema(
                type: 'string'

            )
        ),
        'Cache-Control' => new OA\Header(
            header: 'Cache-Control',
            description: 'The caching policy for the response',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Access-Control-Allow-Origin' => new OA\Header(
            header: 'Access-Control-Allow-Origin',
            description: 'The origin from which the request was made',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Access-Control-Allow-Methods' => new OA\Header(
            header: 'Access-Control-Allow-Methods',
            description: 'The HTTP methods that are allowed',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Access-Control-Allow-Headers' => new OA\Header(
            header: 'Access-Control-Allow-Headers',
            description: 'The HTTP headers that are allowed',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Keep-Alive' => new OA\Header(
            header: 'Keep-Alive',
            description: 'The connection policy for the response',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Connection' => new OA\Header(
            header: 'Connection',
            description: 'The connection policy for the response',
            schema: new OA\Schema(
                type: 'string'
            )
        ),
        'Transfer-Encoding' => new OA\Header(
            header: 'Transfer-Encoding',
            description: 'The encoding used for the response',
            schema: new OA\Schema(
                type: 'string'
            )
        )
    ]
)]
class OpenApi
{}