<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class ArticleRatingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp()
    {
        parent::setUp();

        $this->article = factory(Article::class)->create();
        $this->user = factory(User::class)->create();
    }


    /** @test */
    function it_can_be_rated()
    {
        $this->article->rate(5, $this->user);

        $this->assertCount(1, $this->article->ratings);
    }

    /** @test */
    function it_can_calculate_the_average_rating()
    {
        $this->article->rate(5, $this->user);
        $this->article->rate(1, factory(User::class)->create());

        $this->assertEquals(3, $this->article->rating());
    }

    /** @test */
    function it_cannot_be_rated_above_5()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->article->rate(6);
    }

    /** @test */
    function it_cannot_be_rated_below_1()
    {
        $this->expectException(InvalidArgumentException::class);

        $this->article->rate(-1);
    }

    /** @test */
    function it_can_only_be_rated_once_per_user()
    {
        $this->actingAs($this->user);

        $this->article->rate(5);
        $this->article->rate(1);

        $this->assertEquals(1, $this->article->rating());

    }
}
