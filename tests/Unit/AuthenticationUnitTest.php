<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Hash;

class AuthenticationUnitTest extends JukiverseUnitTestCase
{
  public function test_login_admin_password_is_valid(): void
  {
    $admin = $this->createAdmin();

    $this->assertTrue(Hash::check('admin123', $admin->password));
  }

  public function test_login_admin_password_is_invalid(): void
  {
    $admin = $this->createAdmin();

    $this->assertFalse(Hash::check('wrongpassword', $admin->password));
  }
}