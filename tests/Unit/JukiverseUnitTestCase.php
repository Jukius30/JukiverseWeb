<?php

namespace Tests\Unit;

use App\Models\Admin;
use App\Models\PlayerEmail;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

abstract class JukiverseUnitTestCase extends TestCase
{
  use RefreshDatabase;

  protected string $minecraftUuid = '123e4567-e89b-12d3-a456-426614174000';

  protected function createAdmin(): Admin
  {
    return Admin::create([
      'username' => 'admin',
      'password' => Hash::make('admin123'),
      'display_name' => 'Administrator',
    ]);
  }

  protected function createEmail(): PlayerEmail
  {
    return PlayerEmail::create([
      'minecraft_uuid' => $this->minecraftUuid,
      'minecraft_name' => 'Steve',
      'email_address' => 'steve@example.com',
    ]);
  }

  protected function createProduct(string $name = '1000', string $status = 'active'): Product
  {
    return Product::create([
      'product_name' => $name,
      'product_type' => 'coin',
      'price' => 10000,
      'description' => 'Paket K-Bucks',
      'status' => $status,
    ]);
  }

  protected function createTransaction(string $status = 'pending', string $orderId = 'ORDER-123'): Transaction
  {
    $email = $this->createEmail();
    $product = $this->createProduct();

    return Transaction::create([
      'email_id' => $email->id,
      'product_id' => $product->id,
      'minecraft_uuid' => $this->minecraftUuid,
      'minecraft_name' => 'Steve',
      'midtrans_order_id' => $orderId,
      'payment_status' => $status,
      'amount' => 10000,
    ]);
  }
}