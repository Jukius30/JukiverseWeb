<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Http;

class ProvisionIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testprovisioncommnadexecution(): void
  {
    Http::fake([
      '*' => Http::response([], 200),
    ]);

    $this->createTransaction('pending', 'ORDER-456');

    $this->post('/midtrans/callback', [
      'order_id' => 'ORDER-456',
      'transaction_status' => 'settlement',
    ]);

    $this->assertDatabaseHas('provision_logs', [
      'execution_status' => 'success',
    ]);

    Http::assertSent(function ($request) {
      return str_contains($request['command'], 'nextcredit give Steve 1000');
    });
  }
}