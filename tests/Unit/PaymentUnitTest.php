<?php

namespace Tests\Unit;

class PaymentUnitTest extends JukiverseUnitTestCase
{
  public function test_payment_status_can_be_updated_to_success(): void
  {
    $transaction = $this->createTransaction('pending');

    $transaction->update([
      'payment_status' => 'success',
    ]);

    $this->assertEquals('success', $transaction->fresh()->payment_status);
  }

  public function test_midtrans_order_id_is_saved_correctly(): void
  {
    $transaction = $this->createTransaction('pending', 'ORDER-123');

    $this->assertEquals('ORDER-123', $transaction->midtrans_order_id);
  }
}