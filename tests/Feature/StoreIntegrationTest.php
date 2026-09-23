<?php

namespace Tests\Feature;

class StoreIntegrationTest extends JukiverseIntegrationTestCase
{
  public function teststoreintergration(): void
  {
    $this->createProduct('1000', 'active');
    $this->createProduct('5000', 'inactive');

    $response = $this
      ->withSession($this->playerSession())
      ->get('/store');

    $response->assertStatus(200);
    $response->assertSee('1000');
    $response->assertDontSee('5000');
  }
}