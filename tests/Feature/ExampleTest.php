<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /** @test */
    public function it_goes_to_a_simple_url()
    {
        $this->get('/fadeback')
            ->assertSee('You are here.');
    }
}
