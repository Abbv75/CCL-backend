<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Tournoi extends Model
{
    use HasUuids;

    protected $fillable = [
        'nom',
        'date_debut',
        'frais_inscription',
        'montant_a_gagner',
        'nb_max_participants',
        'id_status'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
    public function parties()
    {
        return $this->hasMany(Partie::class, 'id_tournoi');
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'tournoi_users', 'id_tournoi', 'id_user');
    }
}
