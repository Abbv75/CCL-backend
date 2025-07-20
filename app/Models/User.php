<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasApiTokens, HasFactory;

    protected $table = 'users';
    public $incrementing = false; // car UUID
    protected $keyType = 'string';

    protected $fillable = [
        'id',           // UUID
        'nomComplet',
        'login',
        'motDePasse',
        'idCOD',
        'id_role',
        'id_contact',
    ];

    protected $hidden = [
        'motDePasse',
    ];
    public function getAuthPassword()
    {
        return $this->motDePasse;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact');
    }
    public function parties()
    {
        return $this->belongsToMany(Partie::class, 'partie_users', 'id_user', 'id_partie');
    }
    public function tournois()
    {
        return $this->belongsToMany(Tournoi::class, 'tournoi_users', 'id_user', 'id_tournoi');
    }
}
