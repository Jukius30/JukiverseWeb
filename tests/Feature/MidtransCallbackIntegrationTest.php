<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;

class MidtransCallbackIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testmidtranscallbackupdatespaymentstatus(): void
  {
    Http::fake([
      '*' => Http::response([], 200),
    ]);

    $this->createTransaction('pending', 'ORDER-123');

    $response = $this->post('/midtrans/callback', [
      'order_id' => 'ORDER-123',
      'transaction_status' => 'settlement',
    ]);

    $response->assertStatus(200);

    $this->assertDatabaseHas('transactions', [
      'midtrans_order_id' => 'ORDER-123',
      'payment_status' => 'success',
    ]);
  }
}