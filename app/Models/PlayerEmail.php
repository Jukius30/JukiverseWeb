<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayerEmail extends Model
{
  protected $table = 'emails';

  protected $fillable = [
    'minecraft_uuid',
    'minecraft_name',
    'email_address',
  ];

  public static function findByUuid($uuid)
  {
    return self::where('minecraft_uuid', $uuid)->first();
  }
}