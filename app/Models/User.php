<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model
{
    use HasFactory, HasUuids, HasApiTokens;

    protected $fillable = [
        'nomComplet',
        'login',
        'motDePasse',
        'idCOD',
        'id_role',
        'id_contact',
    ];
    protected $hidden = [
        'password',
    ];
    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact');
    }
    public function partiesGagnees()
    {
        return $this->hasMany(Partie::class, 'id_gagnant');
    }
    public function parties()
    {
        return $this->belongsToMany(Partie::class, 'partie_user', 'id_user', 'id_partie');
    }
}
