<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvisionLog extends Model
{
  protected $table = 'provision_logs';

  protected $fillable = [
    'transaction_id',
    'execution_status',
    'executed_at',
    'message_log',
  ];
}