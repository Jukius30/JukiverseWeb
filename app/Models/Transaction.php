<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
  protected $table = 'transactions';

  protected $fillable = [
    'email_id',
    'product_id',
    'minecraft_uuid',
    'minecraft_name',
    'midtrans_order_id',
    'payment_status',
    'amount',
  ];

  public static function recentByEmailId($emailId, $limit = 5)
  {
    return self::where('email_id', $emailId)
      ->orderBy('created_at', 'desc')
      ->take($limit)
      ->get();
  }

  public function getCoinAmount()
  {
    return (int) ($this->amount / 10);
  }
}