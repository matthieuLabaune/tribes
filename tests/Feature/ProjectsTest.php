<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProjectsTest extends TestCase
{

    use WithFaker, RefreshDatabase;

    /**
     * Only authenticated user can create a new project
     * @return void
     */
    public function test_only_authenticated_user_can_create_projects()
    {
//        $this->withoutExceptionHandling();

        $attributes = Project::factory()->raw();
        $this->post(route('projects.store'), $attributes)->assertRedirect('login');
    }

    /**
     * test a user can create a new project.
     *
     * @return void
     */
    public function test_a_user_can_create_a_project()
    {

        $user = User::factory()->create(['id' => 1]);

        $project = Project::factory()->raw(['user_id' => 1]);



        $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post(route('projects.store'), $project)
            ->assertRedirect('/projects');

        $this->assertDatabaseHas('projects', $project);

        $this->get(route('projects.index'))->assertSee($project['title']);
    }

    /**
     * A user can view a project
     * @return void
     */
    public function test_a__user_can_view_a_project()
    {
        $project = Project::factory()->create();
        $this->get(route('projects.show', [$project->id]))->assertSee([$project->title, $project->description]);
    }

    /**
     * Request when create a new project
     * @return void
     */
    public function test_a_project_created_by_an_authenticated_user_requires_a_title()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $attributes = Project::factory()->raw(['title' => '']);
        $this->post(route('projects.store'), $attributes)->assertSessionHasErrors('title');
    }

    /**
     * Request a description when create a new project
     * @return void
     */
    public function test_a_project_created_by_an_authenticated_user_requires_a_description()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $attributes = Project::factory()->raw(['description' => '']);
        $this->post(route('projects.store'), $attributes)->assertSessionHasErrors('description');
    }


}
