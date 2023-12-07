<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function fullname(): string
    {
        return "$this->firstname $this->lastname";
    }

    public function chat_session_id($id)
    {
        return Session::query()
            ->where(function ($query) use ($id) {
                $query->where('user_1_id', auth()->id())
                    ->where('user_2_id', $id);
            })
            ->orWhere(function ($query) use ($id) {
                $query->where('user_1_id', $id)
                    ->where('user_2_id', auth()->id());
            })
            ->first()->id;;
    }

    public static function otherUsers()
    {
        $instance = new User();
        return $instance->where('id', '!=', auth()->id())->get();
    }

    public function messages($session_id)
    {
        return Chat::where(['session_id' => $session_id])->get();
    }
}
