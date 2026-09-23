<?php

namespace Tests\Feature;

class AuthenticationIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testloginintergrationsucces(): void
  {
    $response = $this->post('/admin/login', [
      'username' => 'admin',
      'password' => 'admin123',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $response->assertSessionHas('admin_logged_in', true);
  }
}