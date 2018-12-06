<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $user;

    public function signIn($user = null)
    {
        if(! $user){
            $user = factory('App\User')->create();
        }
        
        $this->actingAs($user);

        $this->user = $user;

        return $this;
    }
}
