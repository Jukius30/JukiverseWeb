<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Supaya bisa dipakai login Auth Laravel
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'username',
        'password',
        'display_name',
    ];

    // Menyembunyikan password saat data model diubah menjadi array atau JSON
    protected $hidden = [
        'password',
    ];
}