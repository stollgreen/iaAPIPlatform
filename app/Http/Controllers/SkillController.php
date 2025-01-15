<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Http\Resources\SkillCollection;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

/**
 * Class SkillController
 *
 * This controller handles the main operations for skill resource management,
 * including listing, creating, reading, updating, and deleting skills.
 * It also provides supported HTTP methods for the resource.
 */
#[OA\Tag(
    name: 'Skills',
    description: 'Operations for managing skills',
)]
class SkillController extends Controller
{
    /**
     * Display a listing of the skills.
     *
     * @return SkillCollection
     */
    #[OA\Get(
        path: '/skills',
        operationId: 'listSkills',
        description: 'Retrieve a paginated list of skills',
        summary: 'List skills',
        tags: ['Skills'],
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
                description: 'Successfully retrieved list of skills',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/SkillCollection'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function index(): SkillCollection
    {
        $skills = Skill::paginate(request()->input('perPage'));
        return new SkillCollection($skills);
    }

    /**
     * Store a newly created skill in storage.
     *
     * @param SkillStoreRequest $request
     * @return SkillResource
     */
    #[OA\Post(
        path: '/skills',
        operationId: 'createSkill',
        description: 'Create a new skill',
        summary: 'Create a skill',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/SkillStoreRequest')
        ),
        tags: ['Skills'],
        responses: [
            new OA\Response(
                response: 201,
                description: 'Successfully created the skill',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/SkillResource'),
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
    public function store(SkillStoreRequest $request): SkillResource
    {
        $skill = Skill::create($request->validated());
        return new SkillResource($skill);
    }

    /**
     * Display the specified skill.
     *
     * @param Skill $skill
     * @return SkillResource
     */
    #[OA\Get(
        path: '/skills/{skill}',
        operationId: 'showSkill',
        description: 'Retrieve details for a specific skill',
        summary: 'View skill',
        tags: ['Skills'],
        parameters: [
            new OA\PathParameter(
                name: 'skill',
                description: 'The ID of the skill to retrieve',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved the skill details',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/SkillResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Skill not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function show(Skill $skill): SkillResource
    {
        return new SkillResource($skill);
    }

    /**
     * Update the specified skill in storage.
     *
     * @param SkillUpdateRequest $request
     * @param Skill $skill
     * @return SkillResource
     */
    #[OA\Put(
        path: '/skills/{skill}',
        operationId: 'updateSkill',
        description: 'Update an existing skill',
        summary: 'Update skill',
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/SkillUpdateRequest')
        ),
        tags: ['Skills'],
        parameters: [
            new OA\PathParameter(
                name: 'skill',
                description: 'The ID of the skill to update',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 202,
                description: 'Successfully updated the skill',
                x: [
                    new OA\JsonContent(ref: '#/components/schemas/SkillResource'),
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Skill not found',
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
    public function update(SkillUpdateRequest $request, Skill $skill): SkillResource
    {
        $skill->update($request->validated());
        return new SkillResource($skill);
    }

    /**
     * Remove the specified skill from storage.
     *
     * @param Skill $skill
     * @return JsonResponse
     */
    #[OA\Delete(
        path: '/skills/{skill}',
        operationId: 'deleteSkill',
        description: 'Delete a specific skill',
        summary: 'Delete skill',
        tags: ['Skills'],
        parameters: [
            new OA\PathParameter(
                name: 'skill',
                description: 'The ID of the skill to delete',
                required: true,
                schema: new OA\Schema(type: 'integer')
            )
        ],
        responses: [
            new OA\Response(
                response: 204,
                description: 'Successfully deleted the skill',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            ),
            new OA\Response(
                response: 404,
                description: 'Skill not found',
                x: [
                    new OA\Response(ref: '#/components/responses/Default')
                ]
            )
        ]
    )]
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();
        return response()->json([], 204);
    }

    /**
     * Return supported HTTP methods for the 'skills' resource.
     *
     * @return JsonResponse
     */
    #[OA\Get(
        path: '/skills/methods',
        operationId: 'listMethodsSkills',
        description: 'Retrieve the list of supported HTTP methods for skills',
        summary: 'List supported HTTP methods',
        tags: ['Skills'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Successfully retrieved supported methods',
                x: [
                    new OA\JsonContent(
                        title: 'listMethodsSkillsResult',
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
