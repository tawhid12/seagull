<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
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
    ];

    /*
    * relation with role
    */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
    /*One User Multiple Role */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /*
    * relation with company
    */
    public function company()
    {
        return $this->belongsToMany(Company::class,'user_company');
    }
    public function userDetl()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }
    

    public function hasPermission($permissionName)
    {
        return $this->permissions->contains('name', $permissionName);
    }
}
