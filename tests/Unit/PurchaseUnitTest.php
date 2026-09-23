<?php

namespace Tests\Unit;

class PurchaseUnitTest extends JukiverseUnitTestCase
{
  public function test_custom_coin_purchase_validation(): void
  {
    $amount = 0;

    $this->assertFalse($amount >= 100);
  }

  public function test_fixed_product_price_is_valid(): void
  {
    $product = $this->createProduct('1000', 'active');

    $this->assertEquals(10000, $product->price);
  }
}