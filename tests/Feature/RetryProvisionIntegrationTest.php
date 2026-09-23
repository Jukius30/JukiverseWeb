<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class RetryProvisionIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testretryprovisionintergration(): void
  {
    Http::fake([
      '*' => Http::response([], 200),
    ]);

    $transactionId = $this->createTransaction('success', 'ORDER-789');

    $logId = DB::table('provision_logs')->insertGetId([
      'transaction_id' => $transactionId,
      'execution_status' => 'failed',
      'executed_at' => null,
      'message_log' => 'Previous failed command',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $response = $this
      ->withSession($this->adminSession())
      ->post("/admin/provision/retry/{$logId}");

    $response->assertRedirect();

    $this->assertDatabaseHas('provision_logs', [
      'id' => $logId,
      'execution_status' => 'success',
    ]);
  }
}