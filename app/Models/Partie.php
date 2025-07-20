<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Partie extends Model
{
    use HasUuids;

    protected $fillable = ['dateHeure', 'id_tournoi', 'id_gagnant', 'id_status'];

    public function tournoi()
    {
        return $this->belongsTo(Tournoi::class, 'id_tournoi');
    }
    public function gagnant()
    {
        return $this->belongsTo(User::class, 'id_gagnant');
    }
    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'partie_users', 'id_partie', 'id_user');
    }
}
