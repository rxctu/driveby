<?php

namespace Tests\Unit;

use App\Models\User;
use PHPUnit\Framework\TestCase;

class UserModelTest extends TestCase
{
    public function test_is_admin_not_mass_assignable(): void
    {
        $user = new User;
        $this->assertNotContains('is_admin', $user->getFillable());
    }

    public function test_password_is_hashed_cast(): void
    {
        $user = new User;
        $casts = $user->getCasts();

        $this->assertEquals('hashed', $casts['password']);
    }

    public function test_pii_fields_are_encrypted(): void
    {
        $user = new User;
        $casts = $user->getCasts();

        $this->assertEquals('encrypted', $casts['phone']);
        $this->assertEquals('encrypted', $casts['address']);
    }
}
