<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Location;

class LocationControllerTest extends TestCase
{
    use RefreshDatabase; // Ovo će osigurati da se baza podataka resetuje između testova

    public function test_can_create_location(): void
    {
        $data = [
            'city' => 'Belgrade',
            'state' => 'Serbia',
            'country' => 'Serbia',
            'zip_code' => 11000,
            'address' => 'Knez Mihailova'
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment($data);
    }

    public function test_create_location_validation_error(): void
    {
        $data = [
            'city' => '',
            'state' => '',
            'country' => '',
            'zip_code' => 'invalid_zip',
            'address' => ''
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(422); // HTTP 422 Unprocessable Entity
    }

    public function test_can_get_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->getJson("/api/locations/{$location->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment($location->toArray());
    }

    public function test_can_delete_location(): void
    {
        $location = Location::factory()->create();

        $response = $this->deleteJson("/api/locations/{$location->id}");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('locations', ['id' => $location->id]);
    }

    public function test_can_get_all_locations(): void
    {
        $locations = Location::factory()->count(5)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200);
        $response->assertJsonCount(5); // Provjera broja dobijenih lokacija
        $response->assertJsonStructure([
            '*' => [
                'id',
                'city',
                'state',
                'country',
                'zip_code',
                'address',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    public function test_update_invalid_location(): void
    {
        $location = Location::factory()->create();

        $data = [
            'city' => '',
            'state' => '',
            'country' => '',
            'zip_code' => 'invalid_zip',
            'address' => '',
        ];

        $response = $this->putJson("/api/locations/{$location->id}", $data);

        $response->assertStatus(422);
    }

    public function test_update_valid_location(): void
    {
        $location = Location::factory()->create();

        $data = [
            'city' => 'New City',
            'state' => 'New State',
            'country' => 'New Country',
            'zip_code' => 12345,
            'address' => 'New Address',
        ];

        $response = $this->putJson("/api/locations/{$location->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment($data);
    }

}
