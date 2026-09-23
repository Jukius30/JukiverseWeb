<?php

namespace Tests\Feature;

class PaymentIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testpaymentintergration(): void
  {
    $productId = $this->createProduct('1000', 'active');

    $response = $this
      ->withSession($this->playerSession())
      ->post('/purchase', [
        'type' => 'fixed',
        'product_id' => $productId,
      ]);

    $response->assertStatus(200);
    $response->assertSee('1000');
  }
}