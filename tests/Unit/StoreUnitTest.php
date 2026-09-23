<?php

namespace Tests\Unit;

use App\Models\Product;

class StoreUnitTest extends JukiverseUnitTestCase
{
  public function test_store_only_returns_active_product(): void
  {
    $activeProduct = $this->createProduct('1000', 'active');
    $this->createProduct('5000', 'inactive');

    $products = Product::where('status', 'active')->get();

    $this->assertCount(1, $products);
    $this->assertEquals($activeProduct->id, $products->first()->id);
  }
}