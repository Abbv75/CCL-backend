<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

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
