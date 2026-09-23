<?php

namespace Tests\Unit;

use App\Models\ProvisionLog;

class ProvisionUnitTest extends JukiverseUnitTestCase
{
  public function test_provision_command_amount_calculation(): void
  {
    $transaction = $this->createTransaction('success');

    $coinAmount = (int) ($transaction->amount / 10);

    $this->assertEquals(1000, $coinAmount);
  }

  public function test_provision_log_can_be_created(): void
  {
    $transaction = $this->createTransaction('success');

    $log = ProvisionLog::create([
      'transaction_id' => $transaction->id,
      'execution_status' => 'success',
      'executed_at' => now(),
      'message_log' => 'Command executed successfully',
    ]);

    $this->assertEquals('success', $log->execution_status);
  }
}