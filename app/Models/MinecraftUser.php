<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinecraftUser extends Model
{
  protected $connection = 'minecraft_remote';

  protected $table = 'nextcredits_users';

  public $timestamps = false;
}