<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'from_id',
        'message',
        'read',
        'session_id',
    ];

    public function from()
    {
        return $this->belongsTo(\App\Models\User::class, 'from_id');
    }
    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class, 'session_id');
    }
}
