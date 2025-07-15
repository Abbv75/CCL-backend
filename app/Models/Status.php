<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Status extends Model
{
    use HasUuids;

    protected $fillable = ['nom', 'description'];

    public function tournois()
    {
        return $this->hasMany(Tournoi::class, 'id_status');
    }
    public function parties()
    {
        return $this->hasMany(Partie::class, 'id_status');
    }
}
