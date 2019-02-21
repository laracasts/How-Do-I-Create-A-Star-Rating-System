<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ArticleRatingTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function it_cannot_be_rated_by_guests()
    {
        $article = factory(Article::class)->create();

        $this->post("/articles/{$article->id}/rate")->assertRedirect('login');

        $this->assertEmpty($article->ratings);
    }

    /** @test */
    function it_can_be_rated_by_authenticated_users()
    {
        $this->actingAs(
            $user = factory(User::class)->create()
        );

        $article = factory(Article::class)->create();

        $this->post("/articles/{$article->id}/rate", ['rating' => 5]);

        $this->assertEquals(5, $article->rating());
    }

    /** @test */
    function it_can_update_a_users_rating()
    {
        $this->actingAs(
            $user = factory(User::class)->create()
        );

        $article = factory(Article::class)->create();

        $this->post("/articles/{$article->id}/rate", ['rating' => 5]);

        $this->assertEquals(5, $article->rating());

        $this->post("/articles/{$article->id}/rate", ['rating' => 1]);

        $this->assertEquals(1, $article->rating());
    }

    /** @test */
    function it_requires_a_valid_rating()
    {
        $this->actingAs(
            $user = factory(User::class)->create()
        );

        $article = factory(Article::class)->create();

        $this->post("/articles/{$article->id}/rate")->assertSessionHasErrors('rating');

        $this->post("/articles/{$article->id}/rate", ['rating' => 'foo'])->assertSessionHasErrors('rating');
    }
}
