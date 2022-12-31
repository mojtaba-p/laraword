<?php

namespace Tests;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function signIn($role = null)
    {

        $this->be(User::factory()->create(['role' => $role ?? 'user', 'email_verified_at' => now()]));
    }

    /**
     * generates a string like what user can post
     *
     * @return string
     */
    protected function getTags()
    {
        $tag_in_database = Tag::factory()->create()->name;
        $tag_not_in_database = 'new tag';

        return "{$tag_in_database}, {$tag_not_in_database}, other tag ";
    }
}
