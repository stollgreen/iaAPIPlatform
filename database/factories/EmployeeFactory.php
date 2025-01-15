<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Gender;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {

        $gender = $this->faker->randomElement(Gender::all(), rand(1, 2));
        $firstName = $this->faker->firstName($gender);
        $lastName = $this->faker->lastName();
        $domain = $this->faker->freeEmailDomain();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => Str::lower($firstName . '.' . $lastName . '@' . $domain),
            'phone' => $this->faker->phoneNumber(),
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->randomElement([
                'Etage ' . $this->faker->numberBetween(1, 144),
                'Wohnung ' . $this->faker->numberBetween(1, 100) . " " . $this->faker->randomElement(['A', 'B', 'C', 'D']),
                'Postfach ' . $this->faker->buildingNumber(),
                'Gebäude ' . $this->faker->buildingNumber(),
            ]),
            'post_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'country' => Country::factory()->create()->country,
            'hire_date' => $this->faker->date(),
            'birth_date' => $this->faker->date(),
            'gender' => $gender,
            'position' => $this->faker->jobTitle(),
            'department_id' => Department::factory(),
            'salary' => $this->faker->randomFloat(2, 1000, 10000),
        ];
    }
}
