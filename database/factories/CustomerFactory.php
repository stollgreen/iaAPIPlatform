<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Customer;

class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    public function __construct()
    {
        parent::__construct();
        $this->faker = \Faker\Factory::create('de_DE'); // Lokale Sprache setzen
    }

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        $companyName = $this->faker->company();
        $domain = Str::slug($companyName) . '.com'; // Erzeugt eine Domain auf Basis des Firmennamens

        return [
            'name' => $this->faker->name(),
            'company_name' => $companyName . ' ' . $this->faker->randomElement(['GmbH', 'AG', 'KG', 'UG']),
            'email' => $this->faker->userName() . '@' . $domain,
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
            'country' => Country::inRandomOrder()->first()?->id ?? Country::create(['name' => "Deutschland"])->id,
            'vat_number' => $this->faker->numerify('###/#####/####'),
        ];
    }
}
