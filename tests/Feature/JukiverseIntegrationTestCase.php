<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

abstract class JukiverseIntegrationTestCase extends TestCase
{
  use RefreshDatabase;

  protected string $minecraftUuid = '123e4567-e89b-12d3-a456-426614174000';

  protected function setUp(): void
  {
    parent::setUp();

    DB::table('admins')->insert([
      'username' => 'admin',
      'password' => Hash::make('admin123'),
      'display_name' => 'Administrator',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    DB::table('emails')->insert([
      'minecraft_uuid' => $this->minecraftUuid,
      'minecraft_name' => 'Steve',
      'email_address' => 'steve@example.com',
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }

  protected function playerSession(): array
  {
    return [
      'logged_in' => true,
      'uuid' => $this->minecraftUuid,
      'username' => 'Steve',
      'email' => 'steve@example.com',
    ];
  }

  protected function adminSession(): array
  {
    return [
      'admin_logged_in' => true,
      'admin_id' => 1,
      'admin_name' => 'Administrator',
    ];
  }

  protected function createProduct(string $productName = '1000', string $status = 'active'): int
  {
    return DB::table('products')->insertGetId([
      'product_name' => $productName,
      'product_type' => 'coin',
      'price' => 10000,
      'description' => 'Paket K-Bucks',
      'status' => $status,
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }

  protected function createTransaction(string $status = 'pending', string $orderId = 'ORDER-123'): int
  {
    $email = DB::table('emails')
      ->where('minecraft_uuid', $this->minecraftUuid)
      ->first();

    $productId = $this->createProduct();

    return DB::table('transactions')->insertGetId([
      'email_id' => $email->id,
      'product_id' => $productId,
      'minecraft_uuid' => $this->minecraftUuid,
      'minecraft_name' => 'Steve',
      'midtrans_order_id' => $orderId,
      'payment_status' => $status,
      'amount' => 10000,
      'created_at' => now(),
      'updated_at' => now(),
    ]);
  }
}