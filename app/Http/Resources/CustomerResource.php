<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $company_name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $address_line_1
 * @property mixed $address_line_2
 * @property mixed $post_code
 * @property mixed $city
 * @property mixed $country
 * @property mixed $vat_number
 */
#[OA\Schema(
    schema: 'CustomerResource',
    title: 'CustomerResource',
    description: 'Represents a customer',
    required: ['id', 'name', 'company_name', 'email'],
    properties: [
        new OA\Property(property: 'id', description: 'The ID of the customer', type: 'integer'),
        new OA\Property(property: 'name', description: 'The name of the customer', type: 'string'),
        new OA\Property(property: 'company_name', description: 'The customer\'s company name', type: 'string'),
        new OA\Property(property: 'email', description: 'The email of the customer', type: 'string'),
        new OA\Property(property: 'phone', description: 'The phone number of the customer', type: 'string'),
        new OA\Property(property: 'address_line_1', description: 'Primary address line of the customer', type: 'string'),
        new OA\Property(property: 'address_line_2', description: 'Secondary address line of the customer', type: 'string'),
        new OA\Property(property: 'post_code', description: 'Postcode of the customer\'s address', type: 'string'),
        new OA\Property(property: 'city', description: 'City of the customer', type: 'string'),
        new OA\Property(property: 'country', description: 'Country of the customer', type: 'string'),
        new OA\Property(property: 'vat_number', description: 'VAT number of the customer', type: 'string'),
        new OA\Property(property: 'created_at', description: 'Timestamp when the customer was created', type: 'string', format: 'date-time'),
        new OA\Property(property: 'updated_at', description: 'Timestamp when the customer was last updated', type: 'string', format: 'date-time'),
    ],
    type: 'object'
)]
class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'company_name' => $this->company_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address_line_1' => $this->address_line_1,
            'address_line_2' => $this->address_line_2,
            'post_code' => $this->post_code,
            'city' => $this->city,
            'country' => $this->country,
            'vat_number' => $this->vat_number,
        ];
    }
}
