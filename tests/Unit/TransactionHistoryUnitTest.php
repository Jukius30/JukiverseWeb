<?php

namespace Tests\Unit;

use App\Models\Transaction;

class TransactionHistoryUnitTest extends JukiverseUnitTestCase
{
  public function test_transaction_history_can_be_filtered_by_email_id(): void
  {
    $transaction = $this->createTransaction('success', 'ORDER-HISTORY');

    $transactions = Transaction::where('email_id', $transaction->email_id)->get();

    $this->assertCount(1, $transactions);
    $this->assertEquals('ORDER-HISTORY', $transactions->first()->midtrans_order_id);
  }
}