<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\DB;

class AdminTransactionMonitoringIntegrationTest extends JukiverseIntegrationTestCase
{
  public function testadmintransactionmonitoring(): void
  {
    $transactionId = $this->createTransaction('success', 'ORDER-ADMIN');

    DB::table('provision_logs')->insert([
      'transaction_id' => $transactionId,
      'execution_status' => 'success',
      'executed_at' => now(),
      'message_log' => 'Command executed',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    $response = $this
      ->withSession($this->adminSession())
      ->get('/admin/dashboard');

    $response->assertStatus(200);
    $response->assertSee('ORDER-ADMIN');
    $response->assertSee('Steve');
  }
}