<?php

namespace Tests\Unit;

use App\Team;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_team_has_a_name()
    {
        $team = new Team(['name' => 'Acme']);

        $this->assertEquals('Acme',$team->name);
    }

    /** @test */
    public function a_team_can_add_members()
    {
        $team = factory('App\Team')->create();

        $user = factory('App\User')->create();
        $userTwo = factory('App\User')->create();

        $team->add($user);
        $team->add($userTwo);

        $this->assertEquals(2,$team->count());
    }

    /** @test */
    public function a_team_can_add_multiple_members_at_once()
    {
        $team = factory('App\Team')->create();

        $users = factory('App\User',2)->create();

        $team->add($users);

        $this->assertEquals(2,$team->count());
    }

    /** @test */
    public function a_team_has_a_maximum_size()
    {
        $team = factory('App\Team')->create(['size' => 2]);

        $user = factory('App\User')->create();
        $userTwo = factory('App\User')->create();

        $team->add($user);
        $team->add($userTwo);

        $this->assertEquals(2,$team->count());

        $this->expectException('Exception');

        $userThree = factory('App\User')->create();

        $team->add($userThree);
    }
}
