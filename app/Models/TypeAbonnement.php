<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAbonnement extends Model
{
    use HasFactory;
    protected $fillable = [
        'nom',
        'description',
        'prix',
    ];

    protected $casts = [
        'created_at',
        'updated_at',
    ];


    protected $table = 'type_abonnements';
    public function boutiques()
    {
        return $this->hasMany(Boutique::class, 'id_type_abonnement');
    }
}
