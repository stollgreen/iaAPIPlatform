<?php

namespace App\Http\Resources;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $employee_id
 * @property mixed $promoter_group_id
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $skills
 * @property mixed $certifications
 * @property mixed $availability
 * @property BelongsTo $employee
 * @property BelongsTo $promoterGroup
 */
#[OA\Schema(
    schema: "PromoterResource",
    title: "PromoterResource",
    description: "Represents a promoter resource",
    required: ["id", "name", "promoter_group_id", "employee_id"],
    properties: [
        new OA\Property(property: "id", description: "The commitment ID", type: "integer", example: 1),
        new OA\Property(property: "employee_id", description: "The ID of the associated employee", type: "integer", example: 1),
        new OA\Property(property: "promoter_group_id", description: "The group ID the promoter belongs to", type: "integer", example: 8),
        new OA\Property(property: "name", description: "The name of the promoter", type: "string", example: "Max Mustter"),
        new OA\Property(property: "email", description: "The email of the promoter", type: "string", example: "mustermail@musterserver.none"),
        new OA\Property(property: "phone", description: "The phone number of the promoter", type: "string", example: "+49 9276 1194484"),
        new OA\Property(property: "skills", description: "The skills of the promoter", type: "string", example: "Skillname"),
        new OA\Property(property: "certifications", description: "The certifications of the promoter", type: "string", example: "Zertifikatsname"),
        new OA\Property(property: "availability", description: "The availability of the promoter", type: "string", example: "veritatis"),
        new OA\Property(property: "created_at", description: "Timestamp when the promoter group was created", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
        new OA\Property(property: "updated_at", description: "Timestamp when the promoter group was last updated", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
        new OA\Property(property: "employee", title: "EmployeeDetails",
            description: "Employee details",
            properties: [
            new OA\Property(property: "id", type: "integer", example: 1),
            new OA\Property(property: "first_name", type: "string", example: "Max"),
            new OA\Property(property: "last_name", type: "string", example: "Muster"),
            new OA\Property(property: "email", type: "string", example: "mustermail@musterserver.none"),
            new OA\Property(property: "phone", type: "string", example: "02980 692 1491"),
            new OA\Property(property: "address_line_1", type: "string", example: "quasi"),
            new OA\Property(property: "address_line_2", type: "string", example: "nam"),
            new OA\Property(property: "post_code", type: "string", example: "fugiat"),
            new OA\Property(property: "city", type: "string", example: "Siegburg"),
            new OA\Property(property: "country", type: "string", example: null, nullable: true),
            new OA\Property(property: "hire_date", type: "string", format: "date-time", example: "2019-05-02T00:00:00.000000Z"),
            new OA\Property(property: "birth_date", type: "string", format: "date-time", example: "2007-08-07T00:00:00.000000Z"),
            new OA\Property(property: "gender", type: "string", example: null, nullable: true),
            new OA\Property(property: "position", type: "string", example: "voluptas"),
            new OA\Property(property: "department_id", type: "integer", example: 1),
            new OA\Property(property: "salary", type: "number", format: "float", example: 8124.03),
            new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
            new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
        ], type: "object"),
        new OA\Property(
            property: "promoter_group",
            title: "PromoterGroupResource_1", description: "Promoter group details", properties: [
            new OA\Property(property: "id", type: "integer", example: 8),
            new OA\Property(property: "name", type: "string", example: "Vertriebsgruppe"),
            new OA\Property(property: "skills", type: "string", example: "Kreativität"),
            new OA\Property(property: "description", type: "string", example: "Et ratione qui consequatur eum. Magnam et ipsa placeat. Omnis non dolores magnam commodi. Sequi odit eos distinctio sequi ullam repellendus a atque."),
            new OA\Property(property: "max_members", type: "integer", example: 11),
            new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
            new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2025-01-19T18:45:31.000000Z"),
        ], type: "object"),
    ],
    type: "object"
)]
class PromoterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'employee_id' => $this->employee_id,
            'promoter_group_id' => $this->promoter_group_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'skills' => $this->skills,
            'certifications' => $this->certifications,
            'availability' => $this->availability,
            'employee' => $this->employee,
            'promoter_group' => $this->promoterGroup,
        ];
    }
}
