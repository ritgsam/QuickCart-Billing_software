<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Role;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;

public function permissions()
{
    return $this->permissions ? json_decode($this->permissions, true) : [];
}
 public function getPermissionsAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
public function getRoleAttribute($value)
    {
        return ucfirst($value);
    }
public function role() {
        return $this->belongsTo(Role::class);
    }
    /**
     *
     *
     * @var list<string>
     */  protected $fillable = ['name', 'email', 'password', 'role','permissions'];
    protected $casts = ['role' => 'string'];
public $permissions;
    protected $hidden = ['password', 'remember_token'];

}

