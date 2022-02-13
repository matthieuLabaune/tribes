<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A user has projects
     *
     * @return void
     */
    public function test_a_user_has_projects():void
    {

        $user = User::factory()->create();

        $this->assertInstanceOf(Collection::class, $user->projects);
    }
}
