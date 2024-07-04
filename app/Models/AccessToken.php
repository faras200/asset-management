<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessToken extends Model
{
    use HasFactory;
    protected $table = 'access_token';
    protected $fillable = ['token', 'exp_date', 'webhook_date', 'refresh_token'];
    protected $primaryKey = 'id';
}
