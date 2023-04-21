<?php

namespace Database\Seeders;

use App\Models\MissionReport;
use App\Models\User;
use App\Traits\HelperTraits;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Location\Coordinate;

class DatabaseSeederTesting extends Seeder
{
    use HelperTraits;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = json_decode('[
            {
               "first_name":"Yury",
               "last_name":"Gagarin",
               "code_name":"First Man",
               "username":"yuga",
               "email":"yuga@mtr.moon",
               "password":"poleposition1",
               "avatar":"https://upload.wikimedia.org/wikipedia/commons/thumb/f/ff/Yuri_Gagarin_in_1963.jpg/640px-Yuri_Gagarin_in_1963.jpg"
            },
            {
               "first_name":"Alan",
               "last_name":"Shepard",
               "code_name":"Shepard",
               "username":"alsh",
               "email":"alsh@mtr.moon",
               "password":"secret",
               "avatar":"https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/Alan_Shepard_astronaut_in_spacesuit.jpg/640px-Alan_Shepard_astronaut_in_spacesuit.jpg"
            },
            {
               "first_name":"Valentina",
               "last_name":"Tereshkova",
               "code_name":"Valentine",
               "username":"vate",
               "email":"vate@mtr.moon",
               "password":"DQ!cnRVYzQ64@Fwha!XB_kYn",
               "avatar":"https:/upload.wikimedia.org/wikipedia/commons/thumb/6/61/RIAN_archive_612748_Valentina_Tereshkova.jpg/640px-RIAN_archive_612748_Valentina_Tereshkova.jpg"
            },
            {
               "first_name":"Guion",
               "last_name":"Bluford",
               "code_name":"Bluey",
               "username":"gubl",
               "email":"gubl@mtr.moon",
               "password":"STS-8!Challenger1983",
               "avatar":"https://upload.wikimedia.org/wikipedia/commons/thumb0/04/Guion_Bluford.jpg/640px-Guion_Bluford.jpg"
            },
            {
               "first_name":"Andreas",
               "last_name":"Mogensen",
               "code_name":"Great Dane",
               "username":"anmo",
               "email":"anmo@mtr.moon",
               "password":"rødgrødmedfløde",
               "avatar":"https://upload.wikimedia.org/wikipedia/commons/thumb/6/66/ISS-44_Andreas_Mogensen_in_the_Columbus_module.jpg/640px-ISS-44_Andreas_Mogensen_in_the_Columbus_module.jpg"
            },
            {
               "first_name":"Yi",
               "last_name":"So-Yeon",
               "code_name":"Neon",
               "username":"yiso",
               "email":"yiso@mtr.moon",
               "password":"K2t@dACRkGCd3-UQQmCZJbTj",
               "avatar":"https://upload.wikimedia.org/wikipedia/commons/thumb/b/b3/Yi_So-yeon_%28NASA_-_JSC2008-E-004174%29.jpg/640px-Yi_So-yeon_%28NASA_-_JSC2008-E-004174%29.jpg"
            }
        ]');
        foreach ($users as $user) {
            $userObj = new User();
            $userObj->first_name = $user->first_name;
            $userObj->last_name = $user->last_name;
            $userObj->code_name = $user->code_name;
            $userObj->username = $user->username;
            $userObj->email = $user->email;
            $userObj->password = Hash::make($user->password);
            $userObj->avatar = $user->avatar;
            $userObj->save();
        }

        $landpoints = [
            'Europe' => new Coordinate(55.68474022214539, 12.50971483525464),
            'China' => new Coordinate(41.14962602664463, 119.33727554032843),
            'America' => new Coordinate(40.014407426017335, -103.68329704730307),
            'Africa' => new Coordinate(-21.02973667221353, 23.77076788325546),
            'Australia' => new Coordinate(-33.00702098732439, 117.83314818861444),
            'India' => new Coordinate(19.330540162912126, 79.14236662251713),
            'Argentina' => new Coordinate(-34.050351176517886, -65.92682965568743),
        ];
        foreach ($landpoints as $name => $landpoint) {
            $this->addLandpoint($name, $landpoint->getLat(), $landpoint->getLng());
        }
        dump(User::all());
        $testReport = new MissionReport([
            'name' => 'Test report #1',
            'description' => 'En test report',
            'lat' => 20,
            'lon' => -20,
            'mission_date' => '2023-04-20',
            'user_id' => 1,
        ]);
        $testReport->save();
    }
}
