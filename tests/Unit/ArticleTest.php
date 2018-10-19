<?php

use App\Article;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_fetches_trending_articles()
    {
        factory('App\Article',2)->create();
        factory('App\Article')->create(['reads' => 10]);
        $mostPopular = factory('App\Article')->create(['reads' => 20]);

        $articles = Article::trending();

        $this->assertEquals($mostPopular->id,$articles->first()->id);
        $this->assertCount(3,$articles);
    }
}