<?php

namespace Tests\Feature;

class CustomCoinPurchaseValidationIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testcustomcoinpurchasevalidation(): void
  {
    $response = $this
      ->withSession($this->playerSession())
      ->post('/purchase', [
        'type' => 'custom',
        'amount' => 0,
      ]);

    $response->assertSessionHasErrors('amount');
  }
}