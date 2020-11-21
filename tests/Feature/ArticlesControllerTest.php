<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticlesControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreNewArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->followingRedirects();

        $response = $this->post(route('articles.store'), [
            'title' => 'Example title',
            'content' => 'Example content'
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Example title',
            'content' => 'Example content'
        ]);
    }

    public function testDeleteArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);

        $this->followingRedirects();

        $response = $this->delete(route('articles.destroy', $article));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('articles', [
            'user_id' => $user->id,
            'title' => $article->title,
            'content' => $article->content
        ]);
    }

    public function testIndexArticle(): void
    {


        $response = $this->get(route('articles.index'), [
            'title' => 'Example title',
            'content' => 'Example content'
        ]);

        $response->assertStatus(200);

    }

    public function testCreateArticle(): void
    {
        $response = $this->get(route('articles.create'));

        $response->assertStatus(200);
    }

    public function testEditArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.edit', $article));

        $response->assertStatus(200);

    }

    public function testUpdateArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $this->followingRedirects();

        $response = $this->put(route('articles.update', $article), [
            'user_id' => $user->id,
            'title' => 'Example 1title',
            'content' => 'Example 1content'
        ]);

        $this->assertDatabaseHas('articles', [
            'user_id' => $user->id,
            'title' => 'Example 1title',
            'content' => 'Example 1content'
        ]);

        $response->assertStatus(200);
    }

    public function testShowArticle(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $article = Article::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->get(route('articles.show', $article));

        $response->assertStatus(200);
    }

}
