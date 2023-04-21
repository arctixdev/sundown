<?php

namespace Tests\Unit;

use App\Traits\HelperTraits;
use Illuminate\Support\Facades\Artisan;
use Location\Coordinate;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertNotEquals;
use function PHPUnit\Framework\assertNull;
use Tests\TestCase;

/**
 * Test the helper function from the helper traits
 */
class HelperTraitsTest extends TestCase
{
    use HelperTraits;

    /**
     * Test calculating distance.
     */
    public function testCalculateDistance(): void
    {
        $distance = $this->calculateDistance(new Coordinate(50, -10.5), new Coordinate(-18, 10.5));
        $this->assertEquals(7810412.266, $distance);
    }

    public function testAddUser()
    {
        $user = $this->addUser(
            'John',
            'Doe',
            'Heyo',
            'jdoe',
            'john@doe.com',
            'averrysecretpassword',
            'https://avatars.example.com/john-doe.png'
        );
        assertEquals(1, $user->id);
        assertEquals('John', $user->first_name);
        assertEquals('Doe', $user->last_name);
        assertEquals('Heyo', $user->code_name);
        assertNotEquals('averrysecretpassword', $user->password);
        assertNull($user->deleted_at);

    }

    /**public function testDatabaseMigratingAndSeeding() {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
    }*/
}
