<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boutique extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'image',
        'debutAbonnement',
        'finAbonnement',
        'isPartenaire',
        'pourcentageProduit',
        'id_contact',
        'id_type_abonnement',
    ];
    protected $table = 'boutiques';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $casts = [
        'debutAbonnement' => 'datetime',
        'finAbonnement' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    protected $hidden = [];
    public function contact()
    {
        return $this->belongsTo(Contact::class, 'id_contact', 'id');
    }
    public function proprietaire()
    {
        return $this->hasManyThrough(
            User::class,
            Employer::class,
            'id_boutique', // Foreign key on the employer table...
            'id', // Foreign key on the contact table...
            'id', // Local key on the boutique table...
            'id_user' // Local key on the employer table...
        )->with(['contact', 'role']);
    }
    public function employers()
    {
        return $this->hasManyThrough(
            User::class,
            Employer::class,
            'id_boutique', // Foreign key on the employer table...
            'id', // Foreign key on the contact table...
            'id', // Local key on the boutique table...
            'id_user' // Local key on the employer table...
        )->with(['contact', 'role']);
    }
    public function typeAbonnement()
    {
        return $this->belongsTo(TypeAbonnement::class, 'id_type_abonnement', 'id');
    }
    public function produits()
    {
        return $this->hasMany(Produit::class, 'id_boutique', 'id');
    }
    public function ventes()
    {
        return $this->hasMany(Vente::class, 'id_boutique', 'id');
    }
}
