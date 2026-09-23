<?php

namespace Tests\Unit;

class AdminMonitoringUnitTest extends JukiverseUnitTestCase
{
  public function test_admin_transaction_monitoring_data_exists(): void
  {
    $transaction = $this->createTransaction('success', 'ORDER-ADMIN');

    $this->assertDatabaseHas('transactions', [
      'id' => $transaction->id,
      'minecraft_name' => 'Steve',
      'payment_status' => 'success',
    ]);
  }
}