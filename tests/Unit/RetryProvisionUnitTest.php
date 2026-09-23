<?php

namespace Tests\Unit;

use App\Models\ProvisionLog;

class RetryProvisionUnitTest extends JukiverseUnitTestCase
{
  public function test_retry_provision_status_can_be_updated(): void
  {
    $transaction = $this->createTransaction('success');

    $log = ProvisionLog::create([
      'transaction_id' => $transaction->id,
      'execution_status' => 'failed',
      'executed_at' => null,
      'message_log' => 'Previous failed command',
    ]);

    $log->update([
      'execution_status' => 'success',
      'executed_at' => now(),
      'message_log' => 'Retried successfully',
    ]);

    $this->assertEquals('success', $log->fresh()->execution_status);
  }
}