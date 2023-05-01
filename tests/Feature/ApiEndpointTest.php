<?php

namespace Tests\Feature;

use App\Models\MissionImage;
use App\Models\MissionReport;
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
     * Test endpoint dosnt accept unauthorized requests
     */
    public function testAuthRequired()
    {
        $this->get(URL::to('/api/missions'), ['Content-Type' => 'application/json', 'Accept' => 'application/json'])->assertUnauthorized();
    }

    /**
     * Test missions endpoint
     */
    public function testMissionsEndpoint()
    {
        $this->seed(DatabaseSeederTesting::class);
        $missionReport = MissionReport::create([
            'name' => 'Test report #1',
            'description' => 'En test report',
            'lat' => 20,
            'lon' => -20,
            'mission_date' => '2023-04-20',
            'user_id' => 8,
        ]);
        MissionImage::create([
            'camera_name' => 'Sony QWERTY4K',
            'rover_name' => 'Mark rover',
            'rover_status' => 'planting trees',
            'img' => 'Image of a tree being planted',
            'mission_report_id' => $missionReport->id,
        ]);
        Passport::actingAs(User::first());
        $index = $this->get(URL::to('/api/missions'));
        $index->assertOk();
        $index->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'description',
                    'lat',
                    'lon',
                    'mission_date',
                    'user_id',
                    'images' => [
                        '*' => [
                            'id',
                            'camera_name',
                            'rover_name',
                            'rover_status',
                            'img',
                            'mission_report' => [],
                            'created_at',
                            'updated_at',
                        ],
                    ],
                    'user' => [
                        'id',
                        'first_name',
                        'last_name',
                        'code_name',
                        'username',
                        'email',
                        'avatar',
                        'created_at',
                        'updated_at',
                    ],
                ],
            ],
            'links' => [
                'first',
                'last',
                'prev',
                'next',
            ],
            'meta' => [
                'current_page',
                'from',
                'last_page',
                'links' => [],
                'path',
                'per_page',
                'to',
                'total',
            ],
        ]);
        $show = $this->get(URL::to("/api/missions/{$missionReport->id}"));
        $show->assertOk();
        $show->assertValid();
        $update = $this->put(URL::to("/api/missions/{$missionReport->id}?lat=99"));
        $update->assertOk();
        $update->assertValid();
        $this->assertStringContainsString('\"lat\":\"99\",', json_encode($update->decodeResponseJson()));

        /*$store = $this->post(URL::to("/api/missions\
        ?name=Mission#1\
        &description=TheBestMission\
        &lat=25.29\
        &lon=-45.10\
        &mission_date=2023-04-20 10:11:47\
        &user_id=1
        "));
        $store->assertOk();
        $store->assertValid();
        $this->assertDatabaseHas('mission_reports', [
            "name" => "Mission#1",
            "description" => "TheBestMission",
        ]);*/

        $destroy = $this->delete(URL::to("/api/missions/{$missionReport->id}"));
        $destroy->assertOk();
        $destroy->assertContent('1');
    }
}
