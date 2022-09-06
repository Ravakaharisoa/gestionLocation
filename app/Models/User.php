<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'nom',
        'prenom',
        'sexe',
        'telephone1',
        'telephone2',
        'pieceIdentite',
        'numeroPieceIdentite',
        'email',
        'password',
        'photo'
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

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,"user_role","user_id","role_id");
    }

     public function permissions()
    {
        return $this->belongsToMany(Permission::class,"user_permission","user_id","permission_id");
    }

    //cette fonction test si un utilisateur a un role
    public function hasRole($role)
    {
        return $this->roles()->where("nom",$role)->first() !== null;
    }

    //cette fonction test si un utilisateur a plusieurs roles
    public function hasAnyRoles($roles)
    {
        return $this->roles()->whereIn("nom",$roles)->first() !== null;
    }

    public function getAllRoleNamesAttribute()
    {
        return $this->roles->implode('nom',' | ');
    }
}
