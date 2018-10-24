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
    public function a_team_can_remove_members()
    {
        $team = factory('App\Team')->create();

        $users = factory('App\User',2)->create();

        $team->add($users);

        $team->remove($users[0]);

        $this->assertEquals(1,$team->count());
    }

    /** @test */
    public function a_team_can_remove_more_than_one_members_at_once()
    {
        $team = factory('App\Team')->create(['size' => 3]);

        $users = factory('App\User',3)->create();

        $team->add($users);

        $team->remove($users->slice(0,2));

        $this->assertEquals(1,$team->count());
    }

    /** @test */
    public function a_team_can_remove_all_members_at_once()
    {
        $team = factory('App\Team')->create();

        $users = factory('App\User',2)->create();

        $team->add($users);

        $team->restart($users);

        $this->assertEquals(0,$team->count());
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

    /** @test */
    public function when_adding_many_members_at_once_you_still_may_not_exceed_the_team_maximun_size()
    {
        $team = factory('App\Team')->create(['size' => 2]);

        $users = factory('App\User',3)->create();

        $this->expectException('Exception');

        $team->add($users);
    }
}
