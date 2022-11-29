<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\Role;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
    protected $table = "users";
    protected $primaryKey = 'id';
    protected $guarded = [];
    protected $hidden = ['password'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    }

}