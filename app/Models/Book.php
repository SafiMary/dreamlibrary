<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Book extends Model
{
   use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'description',
        'user_id',
    ];

     public function user(){
        return $this->belongsTo(User::class);
    }
}
