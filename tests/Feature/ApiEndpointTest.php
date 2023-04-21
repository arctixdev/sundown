<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeederTesting;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\URL;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ApiEndpointTest extends TestCase
{
    /**
     * Test / dosnt exist
     */
    public function testNoRoot(): void
    {
        $response = $this->get('/');
        $response->assertStatus(404);
    }

    /**
     * Test you can login
     */
    public function testLogin(): void
    {
        // Seed the database so we have a user to login to
        $this->seed(DatabaseSeederTesting::class);
        // Install passport keys
        Artisan::call('passport:install');
        $response = $this->post(URL::to('/api/login'), [
            'email' => 'anmo@mtr.moon',
            'password' => 'rødgrødmedfløde',
        ]);
        $response->assertOk();
        /*$response->assertJsonStructure([
            "
            "
        ]);*/
        $this->assertStringContainsString('{"data":{"first_name":"Andreas","last_name":"Mogensen","email":"anmo@mtr.moon","code_name":"Great Dane","username":"anmo","avatar":"https:\/\/upload.wikimedia.org\/wikipedia\/commons\/thumb\/6\/66\/ISS-44_Andreas_Mogensen_in_the_Columbus_module.jpg\/640px-ISS-44_Andreas_Mogensen_in_the_Columbus_module.jpg","password":"$', $response->baseResponse->content());
            $token = json_decode($response->baseResponse->content())->data->token;
        $this->get(URL::to('/api/validate-token'), [
            'Authorization' => "Bearer {$token}",
        ])->assertOk();
    }

    /**
     * Test missions endpoint
     */
    public function testMissionsEndpoint()
    {
        //$this->seed(DatabaseSeederTesting::class);
        Passport::actingAs(User::first());
        $index = $this->get(URL::to('/api/missions'));
        dump($index);
        $index->assertOk();
    }
}
