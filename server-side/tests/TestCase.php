<?php

namespace Tests;

use App\Models\User\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

    }

    protected function actingAsSuperAdmin($api = null): static
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole('super-admin');
        $this->actingAs($superAdmin, $api);
        return $this;
    }

    /**
     * @param null $api
     * @return TestCase
     */
    protected function actingAsAdmin($api = null): static
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin, $api);
        return $this;
    }

    /**
     * @param null $api
     * @return TestCase
     */
    protected function actingAsUser($api = null): static
    {
        $user = User::factory()->create();
        $this->actingAs($user, $api);
        return $this;
    }


}
